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
        return view('auth.profile', compact('user', 'countries'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|string|max:255',
            'profile_photo_path' => ['nullable', 'mimes:jpeg,jpg,png,webp,gif|max:5120'],
        ]);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), 'profile-photos/', $user->profile_photo_path),
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

        return response()->json(['message' => 'Profile updated successfully'], 200);

    }
    public function verification()
    {
        $user = Auth::user()->load('profile');
        $countries = Travel::countries();
        return view('auth.verification', compact('user','countries'));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
