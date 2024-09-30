<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    const USER_NAME = "superadmin";
    const USER_EMAIL = "superadmin@gmail.com";
    const USER_PWD = "123456";
    public function run() {
        DB::table('users')->insert([
            [
                'name' => self::USER_NAME,
                'email' => self::USER_EMAIL,
                'password' => Hash::make(self::USER_PWD),
            ]
        ]);
    }
}
