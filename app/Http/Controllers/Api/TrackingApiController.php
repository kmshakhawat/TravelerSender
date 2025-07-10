<?php

namespace App\Http\Controllers\Api;

use App\Actions\Travel;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($booking_id)
    {
        $tracking = Tracking::select('status', 'description', 'estimated_delivery', 'status_update_at')
            ->where('booking_id', $booking_id)
            ->orderBy('status_update_at', 'desc')
            ->get()
            ->unique('status');

        $steps = [
            'Processing',
            'Ready for Pickup',
            'Picked Up',
            'In Transit',
            'Arrived at Destination',
            'Attempt to Deliver',
            'Delivered',
        ];
        $currentStatus = Tracking::where('booking_id', $booking_id)
            ->orderBy('status_update_at', 'desc')
            ->value('status');

        $currentStep = array_search($currentStatus, $steps);
        $currentStep = $currentStep !== false ? $currentStep : 0;

        if ($tracking->isEmpty()) {
            return response()->json([
                'success' => false,
                'booking_id' => $booking_id,
                'message' => 'Tracking not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'tracking' => $tracking,
            'booking_id' => $booking_id,
            'currentStep' => $currentStep,
        ], 200);
    }

    public function status()
    {
        abort_if(!request()->ajax(), 403);
        $tracking_status = Travel::trackingStatus();
        return response()->json([
            'success' => true,
            'tracking' => $tracking_status,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'estimated_delivery' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
            ]);
        }


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
    public function search(Request $request)
    {
        $tracking = collect();
        $currentStep = 0;
        $steps = [];
        $completedStatuses = 0;

        $tracking_number = $request->get('trackingNumber');
        if (!$tracking_number) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid tracking number',
            ], 422);
        }

        $booking = Booking::where('tracking_number', $tracking_number)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking not found',
            ],404);
        }

        $steps = [
            'Processing',
            'Ready for Pickup',
            'Picked Up',
            'In Transit',
            'Arrived at Destination',
            'Attempt to Deliver',
            'Delivered',
        ];

        $tracking = Tracking::select('status', 'description', 'estimated_delivery', 'status_update_at')
            ->where('booking_id', $booking->id)
            ->orderBy('status_update_at', 'asc')
            ->get()
            ->reverse()
            ->unique('status')
            ->sortBy(function ($item) use ($steps) {
                return array_search($item->status, $steps);
            })
            ->values();

        $completedStatuses = $tracking->pluck('status')->toArray();
        $currentStatus = end($completedStatuses);
        $currentStep = array_search($currentStatus, $steps);

        return response()->json([
            'success' => true,
            'tracking' => $tracking,
            'booking' => $booking,
            'currentStep' => $currentStep,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tracking $tracking)
    {
        abort_if(!request()->ajax(), 403);
        $tracking->load('latest');
        $tracking_status = collect(Travel::trackingStatus())->except([2, 6])->values();

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
