<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'guest User',
            'email' => 'guest@gmail.com',
            'user_name' => 'guest',
            'email_verified_at' => now(),
            'password' => Hash::make('guest@gmail.com'),
        ]);

    }
}
