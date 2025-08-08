<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingApiController extends Controller
{
    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id)->load('trip');

        if (blank($booking)) {
            return response()->json([
                'success' => false,
                'message' => "Booking not found"
            ], 404);
        }

        $rating = Rating::where('user_id', auth()->id())
            ->where('traveler_id', $booking->trip->user_id)
            ->where('booking_id', $booking->id)
            ->first();

        if ($rating) {
            return response()->json([
                'success' => false,
                'message' => "Rating already exists"
            ], 422);
        }

        $traveler_id = $booking->trip ? $booking->trip->user_id : '';
        $traveler_name =  $booking->trip ? $booking->trip->user->name : '';

        return response()->json([
            'success' => true,
            'booking_id' => $booking_id,
            'traveler_id' => $traveler_id,
            'traveler_name' => $traveler_name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'traveler_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error'
            ], 422);
        }

        Rating::create([
            'user_id' => auth()->id(),
            'traveler_id' => $request->traveler_id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating added successfully'
        ], 200);
    }
}
