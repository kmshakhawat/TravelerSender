<?php

namespace App\Http\Controllers;

use App\Actions\Travel;
use App\Http\Services\FileHandler;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Travel::countries();
        $currency_options = Travel::currencies();
        $id_type_options = Travel::idTypes();
        $user_status_options = Travel::userStatus();
        return view('user.create', compact('countries', 'currency_options', 'user_status_options', 'id_type_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
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
            'status' => $request->status,
            'verified' => $request->verified ? now() : NULL,
            'password' => Hash::make($request->password),
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), '/profile-photos/', ''),
        ]);
        $user->assignRole('user');

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'id_issue' => $request->id_issue,
                'id_expiry' => $request->id_expiry,
                'dob' => $request->dob,
                'id_front' => $this->handleFile($request->file('id_front'), $user->id.'/', null),
                'id_back' => $this->handleFile($request->file('id_back'), $user->id.'/', null),
            ]
        );

        $token = $user->createToken('token')->plainTextToken;

        $mailable_data = [
            'template' => 'emails.welcome',
            'subject' => 'Welcome to our platform',
        ];

        Mail::to($user->email)->send(new SendMail($mailable_data));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::with('profile')->where('id', $user->id)->role('user')->first();
        $countries = Travel::countries();
        $currency_options = Travel::currencies();
        $id_type_options = Travel::idTypes();
        $user_status_options = Travel::userStatus();
        return view('user.edit', compact('user', 'countries', 'currency_options', 'id_type_options', 'user_status_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
//        dd($request->all());
        $user = User::find($user->id)->load('profile');

        if ($request->id_type == 'Passport' || $request->id_type == 'Driving License') {
            $request->validate([
                'id_issue' => 'required|date',
                'id_expiry' => 'required|date',
            ]);
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
            'verified' => $request->verified ? now() : NULL,
            'profile_photo_path'  => $this->handleFile($request->file('profile_photo_path'), $user->id.'/', $user->profile_photo_path),
        ]);


        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'currency_id' => $request->currency_id,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'id_issue' => $request->id_issue,
                'id_expiry' => $request->id_expiry,
                'dob' => $request->dob,
                'id_front' => $this->handleFile($request->file('id_front'), $user->id.'/', $user->profile->id_front ?? null),
                'id_back' => $this->handleFile($request->file('id_back'), $user->id.'/', $user->profile->id_back ?? null),
            ]
        );

    }

    public function updateVerification(Request $request, User $user)
    {
        $user = User::findOrFail($user->id);
        $user->verified = $request->verified ? now() : null; // Update timestamp or set null
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
         return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ], 200);
    }
}
