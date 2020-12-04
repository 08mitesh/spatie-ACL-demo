<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        
            // DB::table('users')->truncate(); //for cleaning earlier data to avoid duplicate entries
            // DB::table('users')->insert([
            //   'name' => 'the admin user',
            //   'email' => 'admin@gmail.com',
            //   'role' => 'admin',
            //   'password' => Hash::make('password'),
            // ]);
    }
}
