<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert user record
        $userId = DB::table('users')->insertGetId([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

       // Get movie_id from the movies table (assuming movie_id = 1 in this example)
       $movieId = 1;

       // Insert favorite movie for the user
       DB::table('favorites')->insert([
           'user_id' => $userId,
           'movie_id' => $movieId,
           'created_at' => now(),
           'updated_at' => now(),
       ]);
    }
}
