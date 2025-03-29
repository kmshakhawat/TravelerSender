<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('password');
        $admin->email_verified_at = now();
        $admin->verified = now();
        $admin->save();
        $admin->profile()->create([
            'country_id' => 232,
        ]);
        $admin->assignRole('admin');
    }
}
