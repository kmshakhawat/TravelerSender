<?php

namespace App\Http\Controllers\Api;

use App\Actions\Travel;
use App\Http\Controllers\Controller;
use App\Http\Resources\WithdrawResource;
use App\Mail\SendMail;
use App\Models\Payment;
use App\Models\UserProfiles;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WithdrawApiController extends Controller
{
    public function index()
    {
        $withdraws = Payment::with(['booking','withdraw'])
            ->where('payment_status', 'paid')
            ->where('status', 'complete')
            ->whereHas('booking', function ($query) {
                $query->where('status', 'Completed');
            })
            ->when(auth()->user()->hasRole('user'), function ($query) {
                $query->where('trip_user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if (blank($withdraws)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'withdraws' => $withdraws
        ], 200);
    }

    public function withdraw(Payment $payment)
    {
        if (blank($payment)) {
            return response()->json([
                'success' => false,
                'message' => 'Withdraw not found',
            ], 404);
        }

        $bank_details = UserProfiles::where('user_id', $payment->trip_user_id)->value('bank_details');

        return response()->json([
            'success' => true,
            'bank_details' => $bank_details,
            'withdraw' => $payment,
        ], 200);

    }

    public function withdrawStore(Payment $payment, Request $request)
    {
        if ($payment->withdraw) {
            return response()->json([
                'success' => false,
                'status' => $payment->withdraw->status,
                'message' => 'A withdraw request for this payment has already been submitted.'
            ], 422);
        }

        if (blank($payment->tripUser) || blank($payment->tripUser->profile) ||  blank($payment->tripUser->profile->bank_details)) {
            return response()->json([
                'success' => false,
                'message' => 'Please add your bank account to your profile first!'
            ], 422);
        }

        $withdraw = Withdraw::create([
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
        $admin_email = config('app.admin.email');
        Mail::to($admin_email)->send(new SendMail($mailable_data_admin));

        $mailable_data = [
            'name' => $payment->tripUser->name,
            'amount' => getPrice($payment->net_amount, $payment->currency),
            'template' => 'emails.withdraw',
            'subject' => 'Withdraw Request',
        ];
        Mail::to($payment->tripUser->email)->send(new SendMail($mailable_data));

        return response()->json([
            'success' => true,
            'message' => 'Withdraw request processed successfully!'
        ], 200);

    }
}
