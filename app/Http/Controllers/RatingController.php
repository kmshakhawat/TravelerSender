<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rating.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id)->load('trip');

        // Check if the authenticated user already rated the traveler
        $rating = Rating::where('user_id', auth()->id())
            ->where('traveler_id', $booking->trip->user_id)
            ->where('booking_id', $booking->id)
            ->first();

        $name = $booking->trip->user->name;
        if ($rating) {
            return redirect()->route('booking.index')->with('error', 'You have already rated this booking.');
        }
        return view('rating.create', compact('name', 'booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'traveler_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        Rating::create([
            'user_id' => auth()->id(),
            'traveler_id' => $request->traveler_id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
