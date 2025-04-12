<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $withdraws = Payment::with(['trip', 'booking', 'withdraw'])
                ->where('payment_status', 'paid')
                ->where('status', 'complete')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $withdraws = Payment::where('trip_user_id', Auth::id())
                ->with(['trip', 'booking', 'withdraw'])
                ->where('payment_status', 'paid')
                ->where('status', 'complete')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('withdraw.index', compact('withdraws'));
    }

    public function withdraw(Payment $payment)
    {
        $payment->load(['tripUser', 'withdraw']);
        $withdraw =  view('withdraw.form', compact('payment'))->render();

        return response()->json([
            'status' => 'success',
            'withdraw' => $withdraw,
        ]);

    }

    public function withdrawStore(Payment $payment, Request $request)
    {
        Withdraw::create([
            'user_id' => $payment->trip_user_id,
            'payment_id' => $payment->id,
            'amount' => $payment->net_amount,
            'currency' => $payment->currency,
            'status' => 'Processing'
        ]);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Withdraw request processed successfully!'
        ]);

    }
}
