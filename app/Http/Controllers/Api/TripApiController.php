<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TripApiController extends Controller
{
    public function index()
    {
        $trips = Trip::where('user_id', Auth::id())->latest()->get();
        return response()->json(['data' => $trips], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_type' => 'required|string',
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
            'type_of_item' => 'nullable|string',
            'packaging_requirement' => 'nullable|string',
            'handling_instruction' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
            'currency' => 'nullable|string',
            'price' => 'nullable|numeric',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('trips', 'public');
            $validated['photo'] = $path;
        }

        $trip = Trip::create($validated);

        return response()->json(['data' => $trip], 201);
    }

    public function show($id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['data' => $trip], 200);
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'trip_type' => 'sometimes|string',
            'mode_of_transport' => 'sometimes|string',
            'vehicle_details' => 'nullable|string',
            'from_address_1' => 'sometimes|string',
            'from_address_2' => 'nullable|string',
            'from_country_id' => 'sometimes|integer',
            'from_state_id' => 'sometimes|integer',
            'from_city_id' => 'sometimes|integer',
            'from_postcode' => 'nullable|string',
            'from_phone' => 'nullable|string',
            'to_address_1' => 'sometimes|string',
            'to_address_2' => 'nullable|string',
            'to_country_id' => 'sometimes|integer',
            'to_state_id' => 'sometimes|integer',
            'to_city_id' => 'sometimes|integer',
            'to_postcode' => 'nullable|string',
            'to_phone' => 'nullable|string',
            'departure_date' => 'sometimes|date',
            'arrival_date' => 'sometimes|date',
            'stopovers' => 'nullable|string',
            'available_space' => 'nullable|string',
            'weight_unit' => 'nullable|string',
            'type_of_item' => 'nullable|string',
            'packaging_requirement' => 'nullable|string',
            'handling_instruction' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
            'currency' => 'nullable|string',
            'price' => 'nullable|numeric',
            'note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($trip->photo) {
                Storage::disk('public')->delete($trip->photo);
            }

            $path = $request->file('photo')->store('trips', 'public');
            $validated['photo'] = $path;
        }

        $trip->update($validated);

        return response()->json(['data' => $trip], 200);
    }

    public function destroy($id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);
        $trip->delete();
        return response()->json(['message' => 'Trip deleted successfully'], 200);
    }
}
