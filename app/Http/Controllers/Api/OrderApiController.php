<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Tracking;
use App\Models\Trip;

class OrderApiController extends Controller
{
    public function index()
    {
        $orders = Booking::with(['products','payment'])
            ->whereHas('trip', function ($query) {
                $query->where('trip_user_id', auth()->id());
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'orders' => $orders
        ], 200);
    }

    public function show(Booking $order)
    {
        if (auth()->user()->hasRole('user') && auth()->user()->id != $order->trip_user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 422);
        }

        $order->load(['products.photos', 'trip']);
        return response()->json([
            'success' => true,
            'order' => $order
        ], 200);
    }

    public function update(Request $request, Booking $order)
    {
        if (auth()->user()->hasRole('user') && auth()->user()->id != $order->trip_user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 422);
        }

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
            'success' => true,
            'order' => $order
        ], 200);
    }
}
