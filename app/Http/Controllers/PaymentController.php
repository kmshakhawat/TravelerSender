<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function handlePaymentCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();
        $payment_id = $request->payment_id;
        if (!$payment_id) {
            return redirect()->route('dashboard')->with('error', 'Invalid Payment ID.');
        }

        $payment = Payment::find($payment_id);
        if (!$payment) {
            return redirect()->route('dashboard')->with('error', 'Payment not found.');
        }

        if ($paymentDetails['data']['status'] === 'success') {
            // Update Booking Status
            $payment->update([
                'trxref' => $paymentDetails['data']['reference'],
                'status' => 'completed'
            ]);
            $booking = $payment->booking;
            $booking->update(['status' => 'Approved']);
            $booking->tracking()->create([
                'booking_id' => $booking->id,
                'status' => 'Processing',
                'status_update_at' => now(),
            ]);
            $booking->trip->update(['status' => 'Confirmed']);

            session(['payment' => $payment]);

            return redirect()->route('payment.success');
        } else {
            return redirect()->route('payment.failed');
        }
    }

    public function success_paystack()
    {
        $payment = session('payment');
        if (!$payment) {
            return redirect()->route('dashboard')->with('error', 'Payment not found.');
        }
        return view('payment.success', compact('payment'));
    }

    public function success(Request $request)
    {
        $payment = Payment::find($request->payment_id);
        if (!$payment) {
            return redirect()->route('dashboard')->with('error', 'Payment not found.');
        }
        $booking = $payment->booking;

        $session = $request->user()->stripe()->checkout->sessions->retrieve($payment->stripe_session_id);
        $payment->update([
            'currency' => $payment->trip->currency,
            'payment_status' => $session->payment_status,
            'status' => ucfirst($session->status),
            'trxref' => $session->payment_intent,
        ]);
        $booking->update(['status' => 'Booked']);
        $booking->tracking()->createMany([
            [
                'booking_id' => $booking->id,
                'status' => 'Processing',
                'status_update_at' => now(),
            ],
            [
                'booking_id' => $booking->id,
                'status' => 'Ready for Pickup',
                'status_update_at' => now(),
            ]
        ]);
        $booking->trip->update(['status' => 'Confirmed']);

        return view('payment.success', compact('payment'));
    }

    public function cancel(Request $request)
    {
        $payment = Payment::find($request->payment_id);
        if ($payment) {
            $payment->update(['payment_status' => 'failed']);
        }

        return redirect()->route('payment.failed')->with('error', 'Payment was canceled.');
    }

    public function failed()
    {
        return view('payment.failed');
    }
}
