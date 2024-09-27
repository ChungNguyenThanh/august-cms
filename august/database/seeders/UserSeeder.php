<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run() {
        DB::table('users')->insert([
            [
                'name' => 'august_admin',
                'email' => 'august-admin@gmail.com',
                'password' => Hash::make('123456'),
            ]
        ]);
    }
}
