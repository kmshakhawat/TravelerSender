<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Models\Tracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($booking_id)
    {
        $tracking = Tracking::select('status', 'description', 'status_update_at')
            ->where('booking_id', $booking_id)
            ->orderBy('status_update_at', 'desc')
            ->get()
            ->unique('status');


        if ($tracking->isEmpty()) {
            return view('tracking.index', ['tracking' => null, 'booking_id' => $booking_id]);
        }

        return view('tracking.index', compact('tracking', 'booking_id'));
    }

    public function status()
    {
        abort_if(!request()->ajax(), 403);
        $tracking_status = Travel::trackingStatus();
        $status = view('tracking.edit', compact('tracking_status'))->render();
        return new JsonResponse([
            'status' => $status,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'estimated_delivery' => 'nullable|date',
        ]);


        $tracking_status = Tracking::where('booking_id', $request->booking_id)
            ->pluck('status')
            ->toArray();
        if (in_array($request->status, $tracking_status)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Tracking status already exists',
            ], 422);
        }

        Tracking::create([
            'booking_id' => $request->booking_id,
            'status' => $request->status,
            'description' => $request->description,
            'estimated_delivery' => $request->estimated_delivery,
            'status_update_at' => now(),
        ]);



        return new JsonResponse([
            'status' => 'success',
            'message' => 'Tracking update successfully',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Tracking $tracking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tracking $tracking)
    {
        abort_if(!request()->ajax(), 403);
        $tracking_status = Travel::trackingStatus();
        $latest = $tracking->latest;
        $edit = view('tracking.edit', compact('tracking', 'latest', 'tracking_status'))->render();
        return new JsonResponse([
            'status' => 'success',
            'edit' => $edit,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tracking $tracking)
    {
        $tracking->update(request()->all());
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Tracking updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracking $tracking)
    {
        //
    }
}
