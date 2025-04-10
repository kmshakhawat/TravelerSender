<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $earnings = Payment::with(['trip', 'booking'])
                ->where('payment_status', 'paid')
                ->where('status', 'complete')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $earnings = Payment::where('trip_user_id', Auth::id())
                ->with(['trip', 'booking'])
                ->where('payment_status', 'paid')
                ->where('status', 'complete')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('earnings.index', compact('earnings'));
    }
}
