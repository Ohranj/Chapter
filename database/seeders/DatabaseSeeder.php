<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Actions\User\CreateSingleUser;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Intl\Countries;

\Locale::setDefault('en');

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(CreateSingleUser $createSingleUser): void
    {
        DB::table('tags')->insert([
            [ 'tag' => 'Fantasy' ],
            [ 'tag' => 'Science Fiction' ],
            [ 'tag' => 'Dystopian' ],
            [ 'tag' => 'Action' ],
            [ 'tag' => 'Adventure' ],
            [ 'tag' => 'Mystery' ],
            [ 'tag' => 'Horror' ],
            [ 'tag' => 'Thriller' ],
            [ 'tag' => 'Historical Fiction' ],
            [ 'tag' => 'Romance' ],
            [ 'tag' => 'Contemporary Fiction' ],
            [ 'tag' => 'Literary Fiction' ],
            [ 'tag' => 'Magical Realism' ],
            [ 'tag' => 'New Adult' ],
            [ 'tag' => 'Biography' ],
            [ 'tag' => 'Self-Help' ],
            [ 'tag' => 'History' ],
            [ 'tag' => 'Travel' ],
            [ 'tag' => 'Crime' ],
            [ 'tag' => 'Comedy' ],
            [ 'tag' => 'Religion' ],
        ]);


        foreach(Countries::getNames() as $country) {
            Country::create([ 'country' => $country ]);
        }
        

        $params = [
            'name' => config('app.master_name'),
            'surname' => config('app.master_surname'),
            'email' => config('app.master_email'),
            'password' => Hash::make(config('app.master_password')),
            'level' => User::USER_TYPES[1]
        ];
        $createSingleUser->run($params);

        
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
