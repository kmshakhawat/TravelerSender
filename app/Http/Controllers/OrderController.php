<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Services\FileHandler;
use App\Models\Booking;
use App\Models\Tracking;
use App\Models\Trip;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Booking::with('products')
            ->whereHas('trip', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('order.index', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trip = Trip::where('id', request('trip'))->first();
        $item_type_option = Travel::itemType();
        $location_type_options = Travel::locationType();
        $collection_type_options = Travel::parcelCollectionType();
        return view('booking.booking-form', compact('trip', 'item_type_option', 'location_type_options', 'collection_type_options'));
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
            'delivery_location' => 'required|string|max:255',
            'delivery_date' => 'required|date',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'products' => 'required|array',
//            'products.*.name' => 'required|string|max:255',
//            'products.*.quantity' => 'required|integer',
//            'products.*.weight' => 'required|numeric',
//            'products.*.weight_type' => 'required|string|max:255',
//            'products.*.length' => 'required|numeric',
//            'products.*.width' => 'required|numeric',
//            'products.*.height' => 'required|numeric',
//            'products.*.images' => 'nullable|array',
//            'products.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->collection_type == 'Collect from Address') {
            $request->validate([
                'pickup_location' => 'required|string|max:255',
                'pickup_date' => 'required|date',
            ]);
        }
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $request->trip_id,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'sender_phone' => $request->sender_phone,
            'collection_type' => $request->collection_type,
            'pickup_location' => $request->pickup_location,
            'pickup_location_type' => $request->pickup_location_type,
            'pickup_date' => $request->pickup_date,
            'receiver_name' => $request->receiver_name,
            'receiver_email' => $request->receiver_email,
            'receiver_phone' => $request->receiver_phone,
            'delivery_location' => $request->delivery_location,
            'delivery_location_type' => $request->delivery_location_type,
            'delivery_date' => $request->delivery_date,
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

        return response()->json([
            'status' => 'success',
            'message' => 'Booking created successfully'
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $order)
    {
        $order->load(['products.photos', 'trip']);
        $order_status = Travel::bookingStatus();
        $tracking_status = Travel::trackingStatus();
        return view('order.show', compact('order', 'order_status', 'tracking_status'));
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
    public function update(Request $request, Booking $order)
    {
        $trip = Trip::firstWhere('id', $order->trip_id);
        $order->update([
            'admin_note' => $request->admin_note,
            'status' => $request->status,
            'tracking_status' => $request->tracking_status,
        ]);

        if ($request->status == 'Approved') {
            $trip->update([
                'status' => 'In Progress'
            ]);
            Tracking::create([
                'booking_id' => $order->id,
                'status' => 'Processing',
                'description' => 'Booking has been approved and is now Processing',
                'status_update_at' => now(),
            ]);
        }
        if ($request->status == 'Rejected') {
            $trip->update([
                'status' => 'Confirmed'
            ]);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully'
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
