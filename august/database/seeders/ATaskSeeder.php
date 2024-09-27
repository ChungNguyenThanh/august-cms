<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ATaskSeeder extends Seeder {
    public function run() {
        DB::table('a_task')->insert([
            [
                'name' => 'a_extend_block_deny',
                'letter' => 'D',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_read',
                'letter' => 'R',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_element_add',
                'letter' => 'E',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_admin_read',
                'letter' => 'S',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_admin_add',
                'letter' => 'T',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_limited_edit',
                'letter' => 'U',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_full_edit',
                'letter' => 'W',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'a_extend_block_full',
                'letter' => 'X',
                'module_id' => 'a_extend_block',
                'sys' => 'Y',
                'description' => '',
                'binding' => 'a_extend_block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
