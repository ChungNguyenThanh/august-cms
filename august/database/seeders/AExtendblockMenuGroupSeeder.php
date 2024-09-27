<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AExtendblockMenuGroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('a_extendblock_menu_group')->insert([
            [
                'name' => 'Admin Left Menu',
                'code' => 'admin_left_menu',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
