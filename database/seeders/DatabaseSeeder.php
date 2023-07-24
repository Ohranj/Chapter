<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => config('app.master_name'),
            'surname' => config('app.master_surname'),
            'email' => config('app.master_email'),
            'password' => Hash::make(config('app.master_password'))
        ]);

        $user->profile()->create();
        $user->privacy()->create();
    }
}
