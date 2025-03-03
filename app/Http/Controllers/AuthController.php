<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use FileHandler;
    public function signup(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation Error',
                ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');
        $token = $user->createToken('token')->plainTextToken;

        $mailable_data = [
            'template' => 'emails.welcome',
            'subject' => 'Welcome to our platform',
        ];

         Mail::to($user->email)->send(new SendMail($mailable_data));

         return response()->json([
             'status' => 'success',
             'message' => 'Registration success',
             'user' => $user,
             'token' => $token,
         ], 200);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function profile()
    {
        $user = Auth::user()->load('profile');
        $countries = Travel::countries();
        $currency_options = Travel::currencies();
        return view('auth.profile', compact('user', 'countries', 'currency_options'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|string|max:255',
            'address_1' => 'required|string',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'profile_photo_path' => ['nullable', 'mimes:jpeg,jpg,png,webp,gif|max:5120'],
        ]);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'currency_id' => $request->currency_id,
            'country_id' => $request->country_id,
            'verified' => $request->verified ? now() : NULL,
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), $user->id.'/', $user->profile_photo_path),
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'city' => $request->city,
                'state' => $request->state,
                'postcode' => $request->postcode,
            ]
        );

        if ($user->verified) {
            return response()->json([
                'redirect' => 'No',
                'message' => 'Profile updated successfully',
            ]);
        }

        return response()->json(['message' => 'Profile updated successfully'], 200);

    }
    public function verification()
    {
        $user = Auth::user()->load('profile');
        $countries = Travel::countries();
        $id_type_options = Travel::idTypes();
        return view('auth.verification', compact('user','countries', 'id_type_options'));
    }
    public function verificationUpdate(Request $request)
    {
        $user = Auth::user()->load('profile');
        $request->validate([
            'id_type' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'id_front' => ['nullable', 'mimes:jpeg,jpg,png,webp,gif|max:5120'],
            'id_back' => ['nullable', 'mimes:jpeg,jpg,png,webp,image/gif|max:5120'],
        ]);

        //if ID Type passport and Driving License then Issue Date adn Expiry Date is required
        if ($request->id_type == 'Passport' || $request->id_type == 'Driving License') {
            $request->validate([
                'id_issue' => 'required|date',
                'id_expiry' => 'required|date',
            ]);
        }
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
                'photo' => $this->handleFile($request->file('profile_photo_path'), $user->id.'/', $user->profile->photo),
            ]
        );

        $mailable_data = [
            'template' => 'emails.verification',
            'subject' => 'User Verification Data Update',
        ];
        Mail::to($user->email)->send(new SendMail($mailable_data));

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
