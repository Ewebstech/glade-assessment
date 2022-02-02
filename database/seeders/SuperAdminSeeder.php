<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Superadmin',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);
    }
}
