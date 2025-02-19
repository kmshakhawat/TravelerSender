<?php

namespace App\Http\Controllers;

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
    public function signup(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

//        dd($validator->errors());

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation Error',
                ], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // send mail
        $mailable_data = [
            'template' => 'emails.welcome',
            'subject' => 'Welcome to our platform',
        ];

         Mail::to($user->email)->send(new SendMail($mailable_data));


        return new JsonResponse([
            'status' => 'success',
            'message' => 'Registration success',
            'user' => $user,
            'token' => $token,
        ], 200);

    }
    // register
    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            // return dashboard based on user role
            if ($user->hasRole('admin')) {
                return response()->json(['token' => $token, 'role' => 'admin'], 200);
            }
            if ($user->hasRole('user')) {
                return response()->json(['token' => $token, 'role' => 'user'], 200);
            }
//            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
