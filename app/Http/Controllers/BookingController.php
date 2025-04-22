<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Middleware\Auth;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\Booking;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Tracking;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Unicodeveloper\Paystack\Facades\Paystack;

class BookingController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $bookings = Booking::with(['products','payment'])
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $bookings = Booking::with(['products','payment'])
                ->where('user_id', auth()->id())
                ->orderBy('id', 'DESC')
                ->paginate(10);
        }
        return view('booking.index', compact('bookings'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->verified) {
            return redirect()->route('trip.search')->with('error', 'Please verify your account before booking again.');
        }

        $trip = Trip::where('id', request('trip'))->first();

        if (!$trip) {
            return redirect()->route('trip.search')->with('error', 'Trip not found.');
        }

        if (auth()->id() === $trip->user_id) {
            return redirect()->route('trip.search')->with('error', 'You’re not allowed to book your own trip.');
        }

        $item_type_option = Travel::itemType();
        $location_type_options = Travel::locationType();
        $collection_type_options = Travel::parcelCollectionType();
        $countries = countries();
        return view('booking.booking-form', compact('trip', 'countries', 'item_type_option', 'location_type_options', 'collection_type_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'required|string|max:255',
            'collection_type' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_email' => 'required|email|max:255',
            'receiver_phone' => 'required|string|max:255',
            'delivery_address_1' => 'required|string|max:255',
            'delivery_country_id' => 'required|integer',
            'delivery_state_id' => 'required|integer',
            'delivery_city' => 'required|string|max:255',
            'delivery_postcode' => 'required|string|max:255',
            'delivery_location_type' => 'required|string|max:255',
            'delivery_date' => 'required|date',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'products' => 'required|array',
        ]);

        if ($request->collection_type == 'Collect from Address') {
            $request->validate([
                'pickup_address_1' => 'required|string|max:255',
                'pickup_country_id' => 'required|integer',
                'pickup_state_id' => 'required|integer',
                'pickup_city' => 'required|string|max:255',
                'pickup_postcode' => 'required|string|max:255',
                'pickup_location_type' => 'required|string|max:255',
                'pickup_date' => 'required|date',
            ]);
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
            'pickup_address_1' => $request->pickup_address_1,
            'pickup_address_2' => $request->pickup_address_2,
            'pickup_country_id' => $request->pickup_country_id,
            'pickup_state_id' => $request->pickup_state_id,
            'pickup_city' => $request->pickup_city,
            'pickup_postcode' => $request->pickup_postcode,
            'pickup_location_type' => $request->pickup_location_type,
            'pickup_date' => $request->pickup_date,
            'receiver_name' => $request->receiver_name,
            'receiver_email' => $request->receiver_email,
            'receiver_phone' => $request->receiver_phone,
            'delivery_address_1' => $request->delivery_address_1,
            'delivery_address_2' => $request->delivery_address_2,
            'delivery_country_id' => $request->delivery_country_id,
            'delivery_state_id' => $request->delivery_state_id,
            'delivery_city' => $request->delivery_city,
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

        $recipients = [
            $booking->user->email => [
                'subject' => 'Your Trip Booking is Confirmed!',
                'template' => 'emails.booking.confirmation'
            ],
            $booking->trip->user->email => [
                'subject' => 'You’ve Received a New Booking for Your Trip!',
                'template' => 'emails.booking.confirmation-traveller'
            ],
            config('app.admin.email') => [
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

//        $paymentData = [
//            'email' => auth()->user()->email, // Customer email
//            'amount' => $payment->amount * 100, // Convert amount to kobo
//            'currency' => $payment->currency,
//            'reference' => Paystack::genTranxRef(), // Generate unique transaction reference
//            'callback_url' => route('payment.callback', ['payment_id' => $payment->id]),
//        ];
//
//        $checkoutSession = Paystack::getAuthorizationUrl($paymentData);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking created successfully',
            'checkout_url' => $checkoutSession->url
        ], 200);

    }

    public function pickup(Booking $booking)
    {
        $pickup = view('order.pickup', compact('booking'))->render();
        return response()->json([
            'status' => 'success',
            'pickup' => $pickup,
        ]);
    }

    public function delivery(Booking $booking)
    {
        $delivery = view('order.delivery', compact('booking'))->render();
        return response()->json([
            'status' => 'success',
            'delivery' => $delivery,
        ]);
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
        $request->validate([
            'type' => 'required|in:pickup,delivery'
        ]);

        if ($request->type === 'pickup') {
            $this->bookingOTP($booking, $booking->sender_email, 'Pickup OTP Verification - ' . config('app.name'));
        } else {
            $this->bookingOTP($booking, $booking->receiver_email, 'Delivery OTP Verification - ' . config('app.name'));
        }

        return new JsonResponse([
            'status' => 'success',
            'message' => 'OTP sent successfully'
        ]);
    }
    public function pickupVerify(Booking $booking, Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);
        if ($request->otp == $booking->otp) {

            Tracking::create([
                'booking_id' => $booking->id,
                'status' => 'Picked Up',
                'status_update_at' => now(),
            ]);
            $booking->update([
                'otp' => null,
            ]);
            $booking->trip->update([
                'status' => 'In Progress'
            ]);

            $this->bookingOTP($booking, $booking->receiver_email, 'Delivery OTP Verification - ' . config('app.name'));

            return new JsonResponse([
                'status' => 'success',
                'message' => 'OTP verified successfully'
            ]);
        }
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Invalid OTP'
        ], 422);
    }

    public function deliveryVerify(Booking $booking, Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);
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
                'status' => 'Booked',
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

            $recipients = [
                $booking->user->email => [
                    'subject' => 'Parcel Delivered Successfully!',
                    'template' => 'emails.booking.delivered'
                ],
                $booking->sender_email => [
                    'subject' => 'Parcel Delivered Successfully!',
                    'template' => 'emails.booking.delivered'
                ],
                config('app.admin.email') => [
                    'subject' => 'Parcel Delivered – '. $booking->user->name .' → ' . $booking->trip->toCountry->name,
                    'template' => 'emails.booking.delivered-admin'
                ]
            ];

            foreach ($recipients as $email => $recipient_data) {
                $mailable_data = array_merge($base_data, $recipient_data);
                Mail::to($email)->send(new SendMail($mailable_data));
            }



            return new JsonResponse([
                'status' => 'success',
                'message' => 'OTP verified successfully'
            ]);
        }
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Invalid OTP'
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        session()->forget('payment');
        $booking->load(['products.photos', 'trip']);
        $booking_status = Travel::bookingStatus();
        return view('booking.show', compact('booking', 'booking_status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $trip = Trip::firstWhere('id', $booking->trip_id);
        $booking->update([
            'admin_note' => $request->admin_note,
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
            'status' => 'success',
            'message' => 'Booking updated successfully'
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
