<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return response()->json(['data' => $bookings], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|integer|exists:trips,id',
            'item_description' => 'required|string',
            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        $booking = Booking::create($validated);

        return response()->json(['data' => $booking], 201);
    }

    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['data' => $booking], 200);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'item_description' => 'sometimes|string',
            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json(['data' => $booking], 200);
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
