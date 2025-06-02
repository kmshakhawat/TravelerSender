<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\Country;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TripController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->verified) {
            return redirect()->route('verification')->with('error', 'Please verify your account to continue');
        }
        return view('trip.index');
    }

    public function search()
    {
        return view('trip.search');

    }

    public function details(Trip $trip)
    {
        $trip->load('stopovers')->load('user');
        return view('trip.details', compact('trip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trip = Trip::all();
        $type_option = Travel::tripTypes();
        $transport_type_option = Travel::transportType();
        $item_type_option = Travel::itemType();
        $handling_instruction_options = Travel::instructionType();
        $packaging_requirement_options = Travel::packagingType();
        $weight_unit_options = Travel::weightUnit();
        $countries = countries();
        return view('trip.create', compact('trip', 'countries', 'type_option', 'transport_type_option', 'item_type_option', 'packaging_requirement_options', 'handling_instruction_options', 'weight_unit_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
//            'trip_type' => 'required',
            'mode_of_transport' => 'required',
            'from_address_1' => 'required',
            'from_country_id' => 'required',
            'from_state_id' => 'required',
            'from_city_id' => 'required',
            'from_phone' => 'required',
            'to_address_1' => 'required',
            'to_country_id' => 'required',
            'to_state_id' => 'required',
            'to_city_id' => 'required',
            'to_phone' => 'required',
            'departure_date' => 'required',
            'arrival_date' => 'required',
            'available_space' => 'required|numeric',
            'weight_unit' => 'required',
            'type_of_item' => 'required',
            'packaging_requirement' => 'required',
            'handling_instruction' => 'required',
            'price' => 'required|numeric',
        ]);

        $departure_date = $request->departure_date;
        $arrival_date = $request->arrival_date;
        $type_of_item = implode(',', $request->type_of_item);

        if ($departure_date > $arrival_date) {
            return response()->json([
                'status' => 'error',
                'message' => 'Departure date cannot be later than the arrival date.',
            ], 422);
        }

        if (!$validate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
            ], 422);
        }

        $trip = Trip::create([
            'user_id' => auth()->id(),
//            'trip_type' => $request->trip_type,
            'mode_of_transport' => $request->mode_of_transport,
            'vehicle_details' => $request->vehicle_details,
            'from_address_1' => $request->from_address_1,
            'from_address_2' => $request->from_address_2,
            'from_country_id' => $request->from_country_id,
            'from_state_id' => $request->from_state_id,
            'from_city_id' => $request->from_city_id,
            'from_postcode' => $request->from_postcode,
            'from_phone' => $request->from_phone,
            'to_address_1' => $request->to_address_1,
            'to_address_2' => $request->to_address_2,
            'to_country_id' => $request->to_country_id,
            'to_state_id' => $request->to_state_id,
            'to_city_id' => $request->to_city_id,
            'to_postcode' => $request->to_postcode,
            'to_phone' => $request->to_phone,
            'departure_date' => $request->departure_date,
            'arrival_date' => $request->arrival_date,
            'available_space' => $request->available_space,
            'weight_unit' => $request->weight_unit,
            'type_of_item' => $type_of_item,
            'packaging_requirement' => $request->packaging_requirement,
            'handling_instruction' => $request->handling_instruction,
            'photo' => $this->handleFile($request->file('photo'), 'trip/', ''),
            'currency' => auth()->user()->currency->code ?? 'NGN',
            'price' => $request->price,
            'note' => $request->note,
            'admin_note' => $request->admin_note,
//            'status' => $request->status,
        ]);


        if ($request->stopovers) {
            $stopovers = collect($request->stopovers)
                ->filter(function ($stopover) {
                    return $stopover !== null && trim($stopover) !== '';
                })
                ->map(function ($stopover) {
                    return ['location' => $stopover];
                })
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
            'status' => 'success',
            'message' => 'Trip created successfully',
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        if (auth()->user()->hasRole('admin')) {
            $trip->load('stopovers');
        } else {
            if ($trip->user_id !== auth()->user()->id) {
                return redirect()->route('trip.index')->with('error', 'Unauthorized access');
            }
            $trip->load('stopovers');
        }

        return view('trip.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        $type_option = Travel::tripTypes();
        $transport_type_option = Travel::transportType();
        $item_type_option = Travel::itemType();
        $handling_instruction_options = Travel::instructionType();
        $packaging_requirement_options = Travel::packagingType();
        $status_options = Travel::tripStatus();
        $weight_unit_options = Travel::weightUnit();
        $countries = countries();

        if (auth()->user()->hasRole('admin')) {
            $trip->load('stopovers');
        } else {
            if ($trip->user_id !== auth()->user()->id) {
                return redirect()->route('trip.index')->with('error', 'Unauthorized access');
            }
            $trip->load('stopovers');
        }
        return view('trip.edit', compact('trip', 'countries', 'type_option', 'transport_type_option', 'item_type_option', 'handling_instruction_options', 'packaging_requirement_options', 'status_options', 'weight_unit_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $validate = $request->validate([
//            'trip_type' => 'required',
            'mode_of_transport' => 'required',
            'from_address_1' => 'required',
            'from_country_id' => 'required',
            'from_state_id' => 'required',
            'from_city_id' => 'required',
            'from_phone' => 'required',
            'to_address_1' => 'required',
            'to_country_id' => 'required',
            'to_state_id' => 'required',
            'to_city_id' => 'required',
            'to_phone' => 'required',
            'departure_date' => 'required',
            'arrival_date' => 'required',
            'available_space' => 'required|numeric',
            'weight_unit' => 'required',
            'type_of_item' => 'required',
            'packaging_requirement' => 'required',
            'handling_instruction' => 'required',
            'price' => 'required|numeric',
        ]);

        $departure_date = $request->departure_date;
        $arrival_date = $request->arrival_date;
        $type_of_item = implode(',', $request->type_of_item);

        if ($departure_date > $arrival_date) {
            return response()->json([
                'status' => 'error',
                'message' => 'Departure date cannot be later than the arrival date.',
            ], 422);
        }

        if (!$validate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
            ], 422);
        }

        $trip->update([
//            'trip_type' => $request->trip_type,
            'mode_of_transport' => $request->mode_of_transport,
            'vehicle_details' => $request->vehicle_details,
            'from_address_1' => $request->from_address_1,
            'from_address_2' => $request->from_address_2,
            'from_country_id' => $request->from_country_id,
            'from_state_id' => $request->from_state_id,
            'from_city_id' => $request->from_city_id,
            'from_postcode' => $request->from_postcode,
            'from_phone' => $request->from_phone,
            'to_address_1' => $request->to_address_1,
            'to_address_2' => $request->to_address_2,
            'to_country_id' => $request->to_country_id,
            'to_state_id' => $request->to_state_id,
            'to_city_id' => $request->to_city_id,
            'to_postcode' => $request->to_postcode,
            'to_phone' => $request->to_phone,
            'departure_date' => $request->departure_date,
            'arrival_date' => $request->arrival_date,
            'available_space' => $request->available_space,
            'weight_unit' => $request->weight_unit,
            'type_of_item' => $type_of_item,
            'packaging_requirement' => $request->packaging_requirement,
            'handling_instruction' => $request->handling_instruction,
            'photo' => $this->handleFile($request->file('photo'), 'trip/', ''),
            'currency' => auth()->user()->currency->code ?? 'NGN',
            'price' => $request->price,
            'note' => $request->note,
            'admin_note' => $request->admin_note,
            'status' => $request->status,
        ]);

        $trip->stopovers()->delete();
        if ($request->stopovers) {
            $stopovers = collect($request->stopovers)
                ->filter(function ($stopover) {
                    return $stopover !== null && trim($stopover) !== '';
                })
                ->map(function ($stopover) {
                    return ['location' => $stopover];
                })
                ->toArray();

            if (!empty($stopovers)) {
                $trip->stopovers()->createMany($stopovers);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Trip updated successfully',
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Trip deleted successfully',
        ], 200);
    }
}
