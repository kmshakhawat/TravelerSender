<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Mail\SendMail;
use App\Models\Payment;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WithdrawController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $withdraws = Payment::with(['booking','withdraw'])
                ->where('payment_status', 'paid')
                ->where('status', 'complete')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $withdraws = Payment::where('trip_user_id', Auth::id())
                ->with(['booking', 'withdraw'])
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
        if ($payment->withdraw) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'A withdraw request for this payment has already been submitted.'
            ], 422);
        }

        if ($payment->tripUser->profile->bank_details == null) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Please add your bank account to your profile first!'
            ], 422);
        }

        Withdraw::create([
            'user_id' => $payment->trip_user_id,
            'payment_id' => $payment->id,
            'amount' => $payment->net_amount,
            'currency' => $payment->currency,
            'pay_to' => $payment->tripUser->profile->bank_account,
            'status' => 'Processing'
        ]);

        $mailable_data_admin = [
            'traveller_name' => $payment->tripUser->name,
            'traveller_email' => $payment->tripUser->email,
            'amount' => getPrice($payment->net_amount, $payment->currency),
            'requested_at' => getDateFormat(now()),
            'template' => 'emails.admin.withdraw',
            'subject' => 'Withdraw Request'. ' - form '. $payment->tripUser->name,
        ];
        Mail::to(config('app.admin.email'))->send(new SendMail($mailable_data_admin));

        $mailable_data = [
            'name' => $payment->tripUser->name,
            'amount' => getPrice($payment->net_amount, $payment->currency),
            'template' => 'emails.withdraw',
            'subject' => 'Withdraw Request',
        ];
        Mail::to($payment->tripUser->email)->send(new SendMail($mailable_data));

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Withdraw request processed successfully!'
        ]);

    }

    public function withdrawPayment(Payment $payment)
    {
        $payment->load(['tripUser', 'withdraw']);

        $statusOptions = Travel::paymentStatus();
        $withdraw =  view('withdraw.pay-form', compact('payment', 'statusOptions'))->render();

        return response()->json([
            'status' => 'success',
            'withdraw' => $withdraw,
        ]);

    }

    public function withdrawUpdate(Payment $payment, Request $request)
    {
        $withdraw = Withdraw::where('payment_id', $payment->id)->first();

        $withdraw->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        $mailable_data = [
            'name' => $payment->tripUser->name,
            'amount' => getPrice($payment->net_amount, $payment->currency),
            'template' => 'emails.withdraw-paid',
            'subject' => 'Withdraw Confirmation',
        ];
        Mail::to($payment->tripUser->email)->send(new SendMail($mailable_data));

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Withdraw request processed successfully!'
        ]);

    }
}
