<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'guest')->first();
        if (!$user) {
            User::create([
                'name' => 'Guest User',
                'username' => 'guest',
                'email' => 'guest@example.com',
                'password' => Hash::make('xenuser'),
            ]);
        }
    }
}
