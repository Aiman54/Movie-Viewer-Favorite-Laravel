<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert movies
        DB::table('movies')->insert([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('movies')->insert([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert more movies as needed
    }
}
