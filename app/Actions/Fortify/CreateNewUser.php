<?php

namespace App\Actions\Fortify;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'email_verified_at' => now(),
            'password' => Hash::make($input['password']),
        ]);
        $user->assignRole('user');
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'currency_id' => 1,
            ]
        );
        $mailable_data = [
            'name' => $user->name,
            'template' => 'emails.welcome',
            'subject' => 'Welcome to '. config('app.name'),
        ];
        Mail::to($user->email)->send(new SendMail($mailable_data));

        return $user;
    }
}
