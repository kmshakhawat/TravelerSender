<?php

namespace App\Http\Controllers\Api;

use App\Actions\Travel;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    use FileHandler;
    // REGISTER API


    public  function dashboard()
    {
        session()->forget('payment');
        $active_trips = Auth::user()->trips()
            ->whereIn('status', ['Active', 'Confirmed', 'In Progress'])
            ->where('departure_date', '>=', Carbon::now())
            ->count();

        $bookings = Booking::with(['products','payment'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->limit(5)->get();

        $trips = Trip::with(['stopovers'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $earnings = Auth::user()->earnings();
        $customers = Booking::whereHas('trip', function ($query) {
            $query->where('user_id', Auth::id());
        })->distinct('user_id')->count('user_id');
        $avg_rating = Auth::user()->averageRating();

        return response()->json([
           'success' => true,
           'active_trips' => $active_trips,
           'bookings' => $bookings,
           'trips' => $trips,
           'earnings' => $earnings,
           'customers' => $customers,
           'avg_rating' => $avg_rating,
        ]);

    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'phone.required' => 'Phone is required',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
                'password.confirmed' => 'Password does not match',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'The email has already been taken.',
                ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');
        $mailable_data = [
            'name' => $user->name,
            'template' => 'emails.welcome',
            'subject' => 'Welcome to our platform',
        ];
        Mail::to($user->email)->send(new SendMail($mailable_data));

        $token = $user->createToken('appToken')->plainTextToken;
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // LOGIN API
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $user = Auth::user();
        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Successful',
            'user' => new UserResource($user),
            'token' => $token,
        ], 200);
    }

    public function otp()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }
        if ($user->otp === null) {
            $this->sendOTPMail();
        }
        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent.',
        ], 200);
    }

    public function otpResend()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }
        $this->sendOTPMail();
        return response()->json([
            'success' => true,
            'otp' => $user->otp,
            'message' => 'OTP has been resent successfully.'
        ], 200);
    }
    private function sendOTPMail()
    {
        $otp = rand(100000, 999999);
        $expiry = now()->addMinutes(7);
        auth()->user()->update([
            'otp' => $otp,
            'otp_expiry' => $expiry
        ]);

        $minutes = $expiry->diff(now())->format('%i minutes and %s seconds');

        $mailableData = [
            'otp' =>    $otp,
            'minutes' =>    $minutes,
            'template'   => 'emails.otp',
            'subject'    => 'OTP Verification - ' . config('app.name'),
        ];
        Mail::to(auth()->user()->email)->send(new SendMail($mailableData));
    }
    public function otpVerify(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric'
        ],
            [
                'otp.required' => 'OTP is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
            [
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 422);
        }


        $user = auth()->user();
        if ($request->otp == $user->otp) {
            if ($user->otp_expiry > now()) {
                $user->update([
                    'otp' => null,
                    'otp_verified' => true,
                    'otp_expiry' => now()->addHours(24)
                ]);

                $token = $user->createToken('appToken')->plainTextToken;

                return response()->json([
                    'message' => 'OTP verified successfully.',
                    'user' => new UserResource($user),
                    'token' => $token,
                    'redirect' => $user->verified ? 'dashboard' : 'profile'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.'
            ], 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.'
        ], 401);
    }

    // LOGOUT API
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
    public function profile()
    {
        $user = Auth::user()->load('profile');
        return response()->json([
            'success' => true,
            'user' => new UserResource($user),
        ], 200);
    }
    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country_id' => 'required',
            'address_1' => 'required|string',
            'city_id' => 'required',
            'postcode' => 'required|string|max:20',
            'profile_photo_path' => ['nullable', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
        ],
            [
                'name.required' => 'Name is required.',
                'phone.required' => 'Phone is required.',
                'country_id.required' => 'Country is required.',
                'address_1.required' => 'Address is required.',
                'city_id.required' => 'City is required.',
                'postcode.required' => 'Postcode is required.',
                'profile_photo_path.max' => 'Profile Photo must be less than 2MB.',
            ]

        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation Error',
                ], 422);
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'verified' => $request->verified ? now() : NULL,
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), $user->id.'/', $user->profile_photo_path),
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'postcode' => $request->postcode,
                'bank_details' => $request->bank_details,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'token' => $user->createToken('appToken')->plainTextToken,
            'redirect' => $user->verified ? 'No' : null,
        ], 200);
    }

    public function verification()
    {
        $user = Auth::user()->load('profile');
        $id_type_options = Travel::idTypes();

        return response()->json([
            'success' => true,
            'user' => new UserResource($user),
            'id_type_options' => $id_type_options,
        ], 200);
    }
    public function verificationUpdate(Request $request)
    {
        $user = Auth::user()->load('profile');
        $validator = Validator::make($request->all(), [
            'id_type' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'id_front' => ['nullable', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
            'id_back' => ['nullable', 'mimes:jpeg,jpg,png,webp,image/gif', 'max:5120'],
            'profile_photo_path' => ['nullable', 'mimes:jpeg,jpg,png,webp,image/gif', 'max:5120'],
        ]);
        if (in_array($request->id_type, ['Passport', 'Driving License'])) {
            $validator->addRules([
                'id_issue' => 'required|date',
                'id_expiry' => 'required|date',
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update([
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), $user->id.'/', $user->profile_photo_path),
        ]);
        $user->profile->updateOrCreate(
            ['user_id' => $user->id],
            [
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'id_issue' => $request->id_issue,
                'id_expiry' => $request->id_expiry,
                'dob' => $request->dob,
                'id_front' => $this->handleFile($request->file('id_front'), $user->id.'/', $user->profile->id_front),
                'id_back' => $this->handleFile($request->file('id_back'), $user->id.'/', $user->profile->id_back),
            ]
        );

        $mailable_data = [
            'name' => $user->name,
            'template' => 'emails.verification-process',
            'subject' => 'Your Verification is in Process',
        ];

        Mail::to($user->email)->send(new SendMail($mailable_data));

        $mailable_data_admin = [
            'name' => $user->name,
            'email' => $user->email,
            'date' => now(),
            'template' => 'emails.verification-submitted',
            'subject' => 'New Verification Submitted by '. $user->name,
        ];
        $admin_email = config('app.admin.email');
        Mail::to($admin_email)->send(new SendMail($mailable_data_admin));


        return response()->json([
            'success' => true,
            'message' => 'Verification data updated successfully',
        ], 200);

    }
}
