<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Services\FileHandler;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('trip.index');
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
        return view('trip.create', compact('trip', 'type_option', 'transport_type_option', 'item_type_option', 'packaging_requirement_options', 'handling_instruction_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'trip_type' => 'required',
            'mode_of_transport' => 'required',
            'from' => 'required',
            'to' => 'required',
            'departure_date' => 'required',
            'arrival_date' => 'required',
            'available_space' => 'required',
            'packaging_requirement' => 'required',
            'handling_instruction' => 'required',
            'price' => 'required',
        ]);

        $departure_date = $request->departure_date;
        $arrival_date = $request->arrival_date;

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
            'trip_type' => $request->trip_type,
            'mode_of_transport' => $request->mode_of_transport,
            'from' => $request->from,
            'to' => $request->to,
            'departure_date' => $request->departure_date,
            'arrival_date' => $request->arrival_date,
            'available_space' => $request->available_space,
            'type_of_item' => $request->type_of_item,
            'packaging_requirement' => $request->packaging_requirement,
            'handling_instruction' => $request->handling_instruction,
            'photo' => $this->handleFile($request->file('photo'), 'trip/', ''),
            'currency' => auth()->user()->currency->code,
            'price' => $request->price,
//            'status' => $request->status,
        ]);

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
        $user = auth()->user()->load('profile');
        return view('trip.show', compact('user', 'trip'));
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
        return view('trip.edit', compact('trip', 'type_option', 'transport_type_option', 'item_type_option', 'handling_instruction_options', 'packaging_requirement_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
