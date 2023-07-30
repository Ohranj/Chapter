<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        User::factory()->count(3)->create()->each(function($x) {
            $x->profile()->create();
            $x->privacy()->create();
        });

        
        Storage::disk('timelines')->deleteDirectory('/');
        Storage::disk('avatars')->deleteDirectory('/');
        Storage::disk('timelines')->makeDirectory('/');
        Storage::disk('avatars')->makeDirectory('/');
    }
}
