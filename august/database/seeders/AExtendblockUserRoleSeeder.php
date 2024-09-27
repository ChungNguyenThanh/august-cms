<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AExtendblockUserRoleSeeder extends Seeder
{
    public function run() {
        DB::table('a_extendblock_user_role')->insert([
            [
                'code' => 'administrator',
                'name' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'editor',
                'name' => 'Editor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'author',
                'name' => 'Author',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'contributor',
                'name' => 'Contributor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'subscriber',
                'name' => 'Subscriber',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}