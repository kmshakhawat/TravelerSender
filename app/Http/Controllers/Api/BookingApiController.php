<?php

namespace App\Http\Controllers\Api;

use App\Actions\Travel;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Payment;
use App\Models\Tracking;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingApiController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['products','payment'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate(10);

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "No bookings found"
            ], 401);
        }
        return response()->json([
            'success' => true,
            'results' => $bookings
        ], 200);
    }

    public function create()
    {
        $trip = Trip::where('id', request('trip'))->first();

        if (auth()->user() && !auth()->user()->verified) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your account before booking again.',
            ], 401);
        }

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, trip not found.',
            ], 422);
        }

        if ($trip->status != 'Active') {
            return  response()->json([
                'success' => false,
                'message' => 'Sorry, trip already booked.',
            ], 422);
        }

        if (auth()->id() === $trip->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, you’re not allowed to book your own trip.',
            ], 422);
        }

        $item_type_option = Travel::itemType();
        $location_type_options = Travel::locationType();
        $collection_type_options = Travel::parcelCollectionType();
        $delivery_type_options = Travel::parcelDeliveryType();
        $countries = countries();

        return response()->json([
            'success' => true,
            'trip' => $trip,
            'item_type_option' => $item_type_option,
            'location_type_option' => $location_type_options,
            'collection_type_option' => $collection_type_options,
            'delivery_type_option' => $delivery_type_options,
            'countries' => $countries,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'required|string|max:255',
            'collection_type' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_email' => 'required|email|max:255',
            'receiver_phone' => 'required|string|max:255',
            'delivery_type' => 'required|string|max:255',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
        ]);

        if ($request->collection_type == 'Collect from Address') {
            $validator->addRules([
                'pickup_address_1' => 'required|string|max:255',
                'pickup_country_id' => 'required|integer',
                'pickup_state_id' => 'required|integer',
                'pickup_city_id' => 'required|string|max:255',
                'pickup_postcode' => 'required|string|max:255',
                'pickup_location_type' => 'required|string|max:255',
                'pickup_date' => 'required|date',
            ]);
        }
        if ($request->collection_type == 'Flexible Meet') {
            $validator->addRules([
                'flexible_place' => 'required',
            ]);
        }
        if ($request->collection_type == 'Send by Friend') {
            $validator->addRules([
                'friend_name' => 'required',
                'friend_email' => 'required',
                'friend_phone' => 'required',
            ]);
        }

        if ($request->delivery_type == 'Deliver to Address') {
            $validator->addRules([
                'delivery_address_1' => 'required|string|max:255',
                'delivery_country_id' => 'required|integer',
                'delivery_state_id' => 'required|integer',
                'delivery_city_id' => 'required|string|max:255',
                'delivery_postcode' => 'required|string|max:255',
                'delivery_location_type' => 'required|string|max:255',
                'delivery_date' => 'required|date',
            ]);
        }
        if ($request->delivery_type == 'Flexible Meet') {
            $validator->addRules([
                'flexible_delivery_place' => 'required',
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }


        $trip_user_id = Trip::where('id', $request->trip_id)->first()->user_id;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'trip_user_id' => $trip_user_id,
            'trip_id' => $request->trip_id,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'sender_phone' => $request->sender_phone,
            'collection_type' => $request->collection_type,
            'flexible_place' => $request->flexible_place,
            'pickup_address_1' => $request->pickup_address_1,
            'pickup_address_2' => $request->pickup_address_2,
            'pickup_country_id' => $request->pickup_country_id,
            'pickup_state_id' => $request->pickup_state_id,
            'pickup_city_id' => $request->pickup_city_id,
            'pickup_postcode' => $request->pickup_postcode,
            'pickup_location_type' => $request->pickup_location_type,
            'pickup_date' => $request->pickup_date,
            'receiver_name' => $request->receiver_name,
            'receiver_email' => $request->receiver_email,
            'receiver_phone' => $request->receiver_phone,
            'delivery_type' => $request->delivery_type,
            'flexible_delivery_place' => $request->flexible_delivery_place,
            'delivery_address_1' => $request->delivery_address_1,
            'delivery_address_2' => $request->delivery_address_2,
            'delivery_country_id' => $request->delivery_country_id,
            'delivery_state_id' => $request->delivery_state_id,
            'delivery_city_id' => $request->delivery_city_id,
            'delivery_postcode' => $request->delivery_postcode,
            'delivery_location_type' => $request->delivery_location_type,
            'delivery_date' => $request->delivery_date,
            'status' => 'Pending',
            'note' => $request->note,
            'admin_note' => $request->admin_note,
        ]);

//        dd($request->products);

        foreach ($request->products as $product) {
            $item = $booking->products()->create([
                'user_id' => auth()->id(),
                'booking_id' => $booking->id,
                'trip_id' => $request->trip_id,
                'name' => $product['name'] ?? null,
                'type' => $product['type'] ?? null,
                'quantity' => $product['quantity'] ?? null,
                'weight' => $product['weight'] ?? null,
                'weight_type' => $product['weight_type'] ?? null,
                'length' => $product['length'] ?? null,
                'width' => $product['width'] ?? null,
                'height' => $product['height'] ?? null,
                'box' => $product['box'] ?? 'No',
                'fragile' => $product['fragile'] ?? 'No',
                'insurance' => $product['insurance'] ?? 'No',
                'urgent' => $product['urgent'] ?? 'No',
                'note' => $product['note'] ?? null,
            ]);
            if (isset($product['images'])) {
                foreach ($product['images'] as $image) {
                    $item->photos()->create([
                        'product_id' => $item->id,
                        'photo_path' => $this->handleFile($image, 'products/', null),
                    ]);
                }
            }
        }


        /* Mail to User */
        $base_data = [
            'name' => $booking->user->name,
            'trip_from' => $booking->trip->fromCountry->name,
            'trip_to' => $booking->trip->toCountry->name,
            'traveller_name' => $booking->trip->user->name,
            'departure_date' => $booking->trip->departure_date,
            'arrival_date' => $booking->trip->arrival_date,
            'created' => $booking->trip->created_at,
            'url' => config('app.url') . '/booking/' . $booking->id,
            'order_url' => config('app.url') . '/order/' . $booking->id,
        ];
        $admin_email = config('app.admin.email');
        $recipients = [
            $booking->user->email => [
                'subject' => 'Your Trip Booking is Confirmed!',
                'template' => 'emails.booking.confirmation'
            ],
            $booking->trip->user->email => [
                'subject' => 'You’ve Received a New Booking for Your Trip!',
                'template' => 'emails.booking.confirmation-traveller'
            ],
            $admin_email => [
                'subject' => 'New Trip Booking Received – '. $booking->user->name .' → ' . $booking->trip->user->name,
                'template' => 'emails.booking.confirmation-admin'
            ]
        ];
        foreach ($recipients as $email => $recipient_data) {
            $mailable_data = array_merge($base_data, $recipient_data);
            Mail::to($email)->send(new SendMail($mailable_data));
        }

        $this->bookingOTP($booking, $request->sender_email, 'Pickup OTP Verification - ' . config('app.name'));

        $payment = Payment::create([
            'user_id' => $booking->user_id,
            'trip_user_id' => $booking->trip_user_id,
            'booking_id' => $booking->id,
            'amount' => $booking->trip->price,
            'currency' => $booking->trip->currency,
            'net_amount' => $booking->trip->price * 0.75,
            'commission' => $booking->trip->price * 0.25,
        ]);

        /* Stripe Payment */
        $checkoutSession = auth()->user()->checkout([
            [
                'price_data' => [
                    'unit_amount' => $payment->amount * 100, // Amount in cents
                    'currency' => $payment->currency,
                    'product_data' => [
                        'name' => 'Booking Payment',
                    ],
                ],
                'quantity' => 1,
            ]
        ], [
            'success_url' => route('payment.success', ['payment_id' => $payment->id]),
            'cancel_url' => route('payment.cancel', ['payment_id' => $payment->id]),
        ]);

        $payment->update([
            'stripe_session_id' => $checkoutSession->id,
        ]);
        /* Stripe Payment */


        return response()->json([
            'success' => true,
            'message' => 'Booking request successfully',
            'checkout_url' => $checkoutSession->url
        ], 200);

    }

    public function show(Booking $booking)
    {
        if (auth()->user()->hasRole('user') && auth()->user()->id != $booking->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 422);
        }

        $booking->load(['products.photos', 'trip']);
//        $booking_status = Travel::bookingStatus();
//        $in_package_product = json_decode($booking->package_condition)->products ?? [];
//        $package_products = $booking->products()->whereIn('id', $in_package_product)->get();
//        $condition_details = json_decode($booking->package_condition)->condition_details ?? '';

        return response()->json([
            'success' => true,
            'booking' => $booking,
//            'booking_status' => $booking_status,
//            'in_package_product' => $in_package_product,
//            'package_products' => $package_products,
//            'condition_details' => $condition_details,
        ], 200);
    }

    public function update(Request $request, Booking $booking)
    {
        if (auth()->user()->hasRole('user') && auth()->user()->id != $booking->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 422);
        }

        $trip = Trip::firstWhere('id', $booking->trip_id);
        $booking->update([
            'admin_note' => $request->admin_note ?? null,
            'status' => $request->status,
        ]);

        if ($request->status == 'Approved') {
            $trip->update([
                'status' => 'In Progress'
            ]);
        }
        if ($request->status == 'Rejected') {
            $trip->update([
                'status' => 'Confirmed'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully'
        ], 200);

    }



    private function bookingOTP(Booking $booking, $email, $subject = null)
    {
        if ($subject) {
            $email_subject = $subject;
        } else {
            $email_subject = 'OTP Verification - ' . config('app.name');
        }
        $otp = rand(100000, 999999);
        $booking->update([
            'otp' => $otp,
        ]);

        $mailableData = [
            'otp' =>    $otp,
            'template'   => 'emails.booking.otp',
            'subject'    => $email_subject,
        ];
        Mail::to($email)->send(new SendMail($mailableData));
    }
    public function otpResend(Booking $booking, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:pickup,delivery'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation error'
            ], 422);
        }

        if ($request->type === 'pickup') {
            $this->bookingOTP($booking, $booking->sender_email, 'Pickup OTP Verification - ' . config('app.name'));
        } else {
            $this->bookingOTP($booking, $booking->receiver_email, 'Delivery OTP Verification - ' . config('app.name'));
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully'
        ]);
    }

    public function pickup(Booking $booking)
    {
        if (blank($booking)) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 422);
        }
        $booking->load('products');
        return response()->json([
            'success' => true,
            'products' => $booking->products
        ]);
    }
    public function pickupVerify(Booking $booking, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation error'
            ], 422);
        }

        $package_condition = [
            'products' => $request->products,
            'condition_details' => $request->condition_details,
        ];


        if ($request->otp == $booking->otp) {
            Tracking::create([
                'booking_id' => $booking->id,
                'status' => 'Picked Up',
                'status_update_at' => now(),
            ]);
            $booking->update([
                'package_condition' => json_encode($package_condition),
                'otp' => null,
            ]);
            $booking->trip->update([
                'status' => 'In Progress'
            ]);

            $this->bookingOTP($booking, $booking->receiver_email, 'Delivery OTP Verification - ' . config('app.name'));

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ], 422);
    }

    public function deliveryVerify(Booking $booking, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation error'
            ], 422);
        }

        if ($request->otp == $booking->otp) {

            $booking->tracking()->createMany([
                [
                    'booking_id' => $booking->id,
                    'status' => 'In Transit',
                    'status_update_at' => now(),
                ],
                [
                    'booking_id' => $booking->id,
                    'status' => 'Arrived at Destination',
                    'status_update_at' => now(),
                ],
                [
                    'booking_id' => $booking->id,
                    'status' => 'Attempt to Deliver',
                    'status_update_at' => now(),
                ],
                [
                    'booking_id' => $booking->id,
                    'status' => 'Delivered',
                    'status_update_at' => now(),
                ]
            ]);
            $booking->update([
                'otp' => null,
                'status' => 'Completed',
            ]);

            $booking->trip->update([
                'status' => 'Completed'
            ]);

            $base_data = [
                'name' => $booking->user->name,
                'trip_from' => $booking->trip->fromCountry->name,
                'trip_to' => $booking->trip->toCountry->name,
                'traveller_name' => $booking->trip->user->name,
                'departure_date' => $booking->trip->departure_date,
                'arrival_date' => $booking->trip->arrival_date,
                'delivery_date' => $booking->trip->updated_at,
                'rating_url' => config('app.url') . '/rating/' . $booking->trip->user->id
            ];

            $admin_email = config('app.admin.email');
            $recipients = [
                $booking->user->email => [
                    'subject' => 'Parcel Delivered Successfully!',
                    'template' => 'emails.booking.delivered'
                ],
                $booking->sender_email => [
                    'subject' => 'Parcel Delivered Successfully!',
                    'template' => 'emails.booking.delivered'
                ],
                $admin_email => [
                    'subject' => 'Parcel Delivered – '. $booking->user->name .' → ' . $booking->trip->toCountry->name,
                    'template' => 'emails.booking.delivered-admin'
                ]
            ];

            foreach ($recipients as $email => $recipient_data) {
                $mailable_data = array_merge($base_data, $recipient_data);
                Mail::to($email)->send(new SendMail($mailable_data));
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ], 422);
    }


}
