<?php

namespace App\Http\Controllers\Api;

use App\Actions\Travel;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Http\Resources\TripResource;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TripApiController extends Controller
{
    use FileHandler;

    public function index(Request $request)
    {
        $from_country = $request->from_country;
        $to_country = $request->to_country;
        $city = $request->city;
        $status = $request->status;
//        $countries = countries();

        $trips = Trip::where('user_id', auth()->user()->id)
            ->with(['stopovers'])
            ->when($from_country, function ($query) use ($from_country) {
                $query->where('from_country_id', $from_country);
            })
            ->when($to_country, function ($query) use ($to_country) {
                $query->where('to_country_id', $to_country);
            })
            ->when($city, function ($query) use ($city) {
                $query->where(function ($q) use ($city) {
                    $q->whereHas('fromCity', function ($q) use ($city) {
                        $q->where('name', 'like', '%' . $city . '%');
                    })->orWhereHas('toCity', function ($q) use ($city) {
                        $q->where('name', 'like', '%' . $city . '%');
                    });
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return TripResource::collection($trips)->additional([
            'success' => true,
        ], 200);
    }

    public function search(Request $request)
    {
        $from = $request->input('from', '');
        $to = $request->input('to', '');
        $departure_date = $request->input('departure_date', '');
        $mode_of_transport = $request->input('mode_of_transport', '');
        $parcel_type = $request->input('parcel_type', '');
        $shorting = $request->input('shorting', '');
        $departure_filter = $request->input('departure_filter', '');
        $review = $request->input('review', '');

        $trips = Trip::when($from, function ($query) use ($from) {
                $query->whereHas('fromCity', function ($query) use ($from) {
                    $query->where('name', 'like', '%' . $from . '%');
                });
                $query->orWhereHas('fromCountry', function ($query) use ($from) {
                    $query->where('name', 'like', '%' . $from. '%');
                });
            })
            ->when($to, function ($query) use ($to) {
                $query->whereHas('toCity', function ($query) use ($to) {
                    $query->where('name', 'like', '%' . $to . '%');
                });
                $query->orWhereHas('toCountry', function ($query) use ($to) {
                    $query->where('name', 'like', '%' . $to . '%');
                });
            })
            ->when($departure_date, function ($query) use ($departure_date) {
                $query->whereDate('departure_date', Carbon::parse($departure_date)->format('Y-m-d'));
            })
            ->where('status', 'Active')
            ->where('user_id', '!=', auth()->id())
            ->when($parcel_type, function ($query) use ($parcel_type) {
                $query->where('handling_instruction', $parcel_type);
            })
            ->when($mode_of_transport, function ($query) use ($mode_of_transport) {
                $query->where('mode_of_transport', $mode_of_transport);
            })
            ->when($shorting, function ($query) use ($shorting) {
                switch ($shorting) {
                    case 'lowest_price':
                        $query->orderBy('price', 'ASC');
                        break;
                    case 'highest_price':
                        $query->orderBy('price', 'DESC');
                        break;
                    case 'highest_reward':
                        $query->orderBy('reward', 'DESC');
                        break;
                    default:
                        $query->orderBy('departure_date', 'ASC'); // Default
                        break;
                }
            })
            ->when($departure_filter, function ($query) use ($departure_filter) {
                switch ($departure_filter) {
                    case 'today':
                        $query->whereDate('departure_date', Carbon::today());
                        break;
                    case 'tomorrow':
                        $query->whereDate('departure_date', Carbon::tomorrow());
                        break;
                    case 'this_week':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addWeek()]);
                        break;
                    case '15_days':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addDays(15)]);
                        break;
                    case 'this_month':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addMonth()]);
                        break;
                    default:
                        $query->where('departure_date', '>=', Carbon::now());
                        break;
                }
            })
            ->when($review, function ($query) use ($review) {
                $query->whereHas('user', function ($q) use ($review) {
                    $q->whereHas('ratings', function ($r) use ($review) {
                        $r->where('rating', '>=', $review);
                    });
                });
            })
            ->where('departure_date', '>=', Carbon::now())
            ->orderBy('departure_date', 'ASC')
            ->with('user')
            ->paginate(10);


        return TripResource::collection($trips)->additional([
            'success' => true,
        ], 200);
    }

    public function details(Trip $trip)
    {
        $trip->load('stopovers')->load('user');
        return response()->json([
            'success' => true,
            'trip' => new TripResource($trip),
        ]);
    }

    public function locations(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');

        $data = Country::all();
        if ($country_id) {
            $data = State::where('country_id', $country_id)->get();
        }
        if ($state_id) {
            $data = City::where('state_id', $state_id)->get();
        }
        if ($city_id) {
            $data = City::where('id', $city_id)->get();
        }
        return response()->json([
            'success' => true,
            'data' => LocationResource::collection($data),
        ]);
    }


    public function allLocations(Request $request)
    {
        $query = $request->get('q', '');
        $hitsPerPage = $request->get('hits_per_page', 5);

        // Search all three indices simultaneously
        $countriesPromise = Country::search($query)->take($hitsPerPage);
        $statesPromise = State::search($query)->take($hitsPerPage);
        $citiesPromise = City::search($query)->take($hitsPerPage);

        // Execute all searches
        $countries = $countriesPromise->get();
        $states = $statesPromise->get();
        $cities = $citiesPromise->get();

        // Combine results with type identifier
        $results = collect()
            ->merge($countries->map(function ($hit) {
                return array_merge($hit->toArray(), ['type' => 'Country']);
            }))
            ->merge($states->map(function ($hit) {
                return array_merge($hit->toArray(), ['type' => 'State']);
            }))
            ->merge($cities->map(function ($hit) {
                return array_merge($hit->toArray(), ['type' => 'City']);
            }));

        return response()->json([
            'success' => true,
            'locations' => $results->all(),
            'total' => $results->count(),
            'breakdown' => [
                'countries' => $countries->count(),
                'states' => $states->count(),
                'cities' => $cities->count(),
            ]
        ], 200);
    }

    public function create()
    {
        $type_option = Travel::tripTypes();
        $transport_type_option = Travel::transportType();
        $item_type_option = Travel::itemType();
        $handling_instruction_options = Travel::instructionType();
        $packaging_requirement_options = Travel::packagingType();
        $weight_unit_options = Travel::weightUnit();
        $countries = countries();

        return response()->json([
            'success' => true,
            'type_option' => $type_option,
            'transport_type_option' => $transport_type_option,
            'item_type_option' => $item_type_option,
            'handling_instruction_options' => $handling_instruction_options,
            'packaging_requirement_options' => $packaging_requirement_options,
            'weight_unit_options' => $weight_unit_options,
            'countries' => $countries
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mode_of_transport' => 'required|string',
            'vehicle_details' => 'nullable|string',
            'from_address_1' => 'required|string',
            'from_address_2' => 'nullable|string',
            'from_country_id' => 'required|integer',
            'from_state_id' => 'required|integer',
            'from_city_id' => 'required|integer',
            'from_postcode' => 'nullable|string',
            'from_phone' => 'required|string',
            'to_address_1' => 'required|string',
            'to_address_2' => 'nullable|string',
            'to_country_id' => 'required|integer',
            'to_state_id' => 'required|integer',
            'to_city_id' => 'required|integer',
            'to_postcode' => 'nullable|string',
            'to_phone' => 'required|string',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'stopovers' => 'nullable|string',
            'available_space' => 'required|string',
            'weight_unit' => 'required|string',
            'type_of_item' => 'required|string',
            'packaging_requirement' => 'required|string',
            'handling_instruction' => 'required|string',
            'photo' => 'nullable|image|max:5120',
            'currency' => 'nullable|string',
            'price' => 'required|numeric',
            'note' => 'nullable|string',
            'status' => 'nullable|string',
        ],
            [
                'mode_of_transport.required' => 'The mode of transport is required.',
                'from_address_1.required' => 'The address field is required.',
                'from_country_id.required' => 'The country field is required.',
                'from_state_id.required' => 'The state field is required.',
                'from_city_id.required' => 'The city field is required.',
                'to_address_1.required' => 'The address field is required.',
                'to_country_id.required' => 'The country field is required.',
                'to_state_id.required' => 'The state field is required.',
                'to_city_id.required' => 'The city field is required.',
                'departure_date.required' => 'The departure date field is required.',
                'arrival_date.required' => 'The arrival date field is required.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error'
            ], 422);
        }

        $departure_date = $request->departure_date;
        $arrival_date = $request->arrival_date;

        if ($departure_date > $arrival_date) {
            return response()->json([
                'success' => false,
                'message' => 'Departure date cannot be later than the arrival date.',
            ], 422);
        }


        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['currency'] = auth()->user()->currency->code ?? 'NGN';
        $data['photo'] = $this->handleFile($request->file('photo'), 'trip/', '');

        unset($data['stopovers']);


        $trip = Trip::create($data);

        if ($request->stopovers) {
            $stopovers = collect(explode(',', implode(',', (array) $request->stopovers)))
                ->map(fn($s) => trim($s))
                ->filter()
                ->map(fn($s) => ['location' => $s])
                ->values()
                ->toArray();

            if (!empty($stopovers)) {
                $trip->stopovers()->createMany($stopovers);
            }
        }
        $mailable_data = [
            'name' => $trip->user->name,
            'template' => 'emails.add-trip',
            'subject' => 'Your Trip Has Been Successfully Added',
        ];
        Mail::to($trip->user->email)->send(new SendMail($mailable_data));

        $mailable_data_admin = [
            'name' => $trip->user->name,
            'email' => $trip->user->email,
            'trip_from' => $trip->fromCountry->name,
            'trip_to' => $trip->toCountry->name,
            'departure_date' => $trip->departure_date,
            'arrival_date' => $trip->arrival_date,
            'created' => $trip->created_at,
            'template' => 'emails.add-trip-admin',
            'subject' => ' New Trip Added by '. $trip->user->name,
        ];
        $admin_email = config('app.admin.email');
        Mail::to($admin_email)->send(new SendMail($mailable_data_admin));

        return response()->json([
            'success' => true,
            'trip' => $trip,
            'message' => 'Trip Has Been Successfully Added',
        ], 201);
    }

    public function show(Trip $trip)
    {
        if ($trip->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot access this trip'
            ], 401);
        }
        $trip->load('stopovers');


        return response()->json([
            'success' => true,
            'trip' => new TripResource($trip)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'mode_of_transport' => 'required|string',
            'vehicle_details' => 'nullable|string',
            'from_address_1' => 'required|string',
            'from_address_2' => 'nullable|string',
            'from_country_id' => 'required|integer',
            'from_state_id' => 'required|integer',
            'from_city_id' => 'required|integer',
            'from_postcode' => 'nullable|string',
            'from_phone' => 'nullable|string',
            'to_address_1' => 'required|string',
            'to_address_2' => 'nullable|string',
            'to_country_id' => 'required|integer',
            'to_state_id' => 'required|integer',
            'to_city_id' => 'required|integer',
            'to_postcode' => 'nullable|string',
            'to_phone' => 'nullable|string',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'stopovers' => 'nullable|string',
            'available_space' => 'nullable|string',
            'weight_unit' => 'nullable|string',
            'type_of_item' => 'required|string',
            'packaging_requirement' => 'nullable|string',
            'handling_instruction' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
            'currency' => 'nullable|string',
            'price' => 'nullable|numeric',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'status' => 'nullable|string',
        ],
            [
                'mode_of_transport.required' => 'The mode of transport is required.',
                'from_address_1.required' => 'The address field is required.',
                'from_country_id.required' => 'The country field is required.',
                'from_state_id.required' => 'The state field is required.',
                'from_city_id.required' => 'The city field is required.',
                'to_address_1.required' => 'The address field is required.',
                'to_country_id.required' => 'The country field is required.',
                'to_state_id.required' => 'The state field is required.',
                'to_city_id.required' => 'The city field is required.',
                'departure_date.required' => 'The departure date field is required.',
                'arrival_date.required' => 'The arrival date field is required.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error'
            ], 422);
        }

        $departure_date = $request->departure_date;
        $arrival_date = $request->arrival_date;

        if ($departure_date > $arrival_date) {
            return response()->json([
                'success' => false,
                'message' => 'Departure date cannot be later than the arrival date.',
            ], 422);
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['currency'] = auth()->user()->currency->code ?? 'NGN';
        $data['photo'] = $this->handleFile($request->file('photo'), 'trip/', '');

        unset($data['stopovers']);

        $trip->update($data);


        $newStopovers = collect(explode(',', implode(',', (array) $request->stopovers)))
            ->map(fn($s) => trim($s))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Get existing locations
        $oldStopovers = $trip->stopovers()->pluck('location')->toArray();

        // Find to delete
        $toDelete = array_diff($oldStopovers, $newStopovers);
        if (!empty($toDelete)) {
            $trip->stopovers()->whereIn('location', $toDelete)->delete();
        }

        // Find to insert
        $toInsert = array_diff($newStopovers, $oldStopovers);
        if (!empty($toInsert)) {
            $trip->stopovers()->createMany(
                collect($toInsert)->map(fn($loc) => ['location' => $loc])->all()
            );
        }

        return response()->json([
            'success' => true,
            'trip' => $trip,
            'message' => 'Trip Has Been Successfully Updated',
        ], 200);

    }

    public function destroy($id)
    {
        $trip = Trip::where('user_id', Auth::id())->where('id', $id)->first();
        if(!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip Not Found',
            ], 422);
        }

        $trip->delete();
        return response()->json([
            'success' => true,
            'message' => 'Trip deleted successfully'
        ], 200);
    }

    public function filter()
    {
        $transport_type = Travel::transportType();
        $instruction_type = Travel::instructionType();
        $id_types = Travel::idTypes();
        $item_type = Travel::itemType();
        $packaging_type = Travel::packagingType();
        $trip_status = Travel::tripStatus();
        $booking_status = Travel::bookingStatus();
        $tracking_status = Travel::trackingStatus();
        $weight_unit = Travel::weightUnit();
        $location_type = Travel::locationType();
        $parcel_collection_type = Travel::parcelCollectionType();
        $parcel_delivery_type = Travel::parcelDeliveryType();
        $payment_status = Travel::paymentStatus();
        $data = [
            'mode_of_transport' => $transport_type,
            'parcel_type' =>  $instruction_type,
            'id_type' => $id_types,
            'item_type' => $item_type,
            'packaging_type' => $packaging_type,
            'trip_status' => $trip_status,
            'booking_status' => $booking_status,
            'tracking_status' => $tracking_status,
            'weight_unit' => $weight_unit,
            'location_type' => $location_type,
            'parcel_collection_type' => $parcel_collection_type,
            'parcel_delivery_type' => $parcel_delivery_type,
            'payment_status' => $payment_status,
            'shorting' => [
                [
                  'id' => 'lowest_price',
                  'name' => 'Price (Low > High)',
                ],
                [
                  'id' => 'highest_price',
                  'name' => 'Price (High > Low)',
                ]
            ],
            'departure_filter' => [
                [
                    'id' => 'today',
                    'name' => 'Today',
                ],
                [
                    'id' => 'tomorrow',
                    'name' => 'Tomorrow',
                ],
                [
                    'id' => 'this_week',
                    'name' => 'This Week',
                ],
                [
                    'id' => '15_days',
                    'name' => 'Within 15 Days',
                ],
                [
                    'id' => 'this_month',
                    'name' => 'Within 1 Month',
                ]
            ],
            'review' => [
                [
                    'id' => '5',
                    'name' => '5 Star',
                ],
                [
                    'id' => '4',
                    'name' => '4 Star',
                ],
                [
                    'id' => '3',
                    'name' => '3 Star',
                ],
                [
                    'id' => '2',
                    'name' => '2 Star',
                ],
                [
                    'id' => '1',
                    'name' => '1 Star',
                ],
                [
                    'id' => '0',
                    'name' => 'Unrated',
                ],

            ]

        ];
        return response()->json([
            'success' => true,
            'results' => $data
        ], 200);


    }
}
