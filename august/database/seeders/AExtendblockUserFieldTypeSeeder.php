<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AExtendblockUserFieldTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('a_extendblock_user_field_type')->insert([
            [
                'code' => 'string',
                'user_field_type' => 'String',
                'db_type' => 'varchar(255)',
                'accessori_type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'int',
                'user_field_type' => 'Integer',
                'db_type' => 'int',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'datetime',
                'user_field_type' => 'DateTime',
                'db_type' => 'datetime',
                'accessori_type' => 'datetime',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'date',
                'user_field_type' => 'Date',
                'db_type' => 'date',
                'accessori_type' => 'date',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'float',
                'user_field_type' => 'Float',
                'db_type' => 'double',
                'accessori_type' => 'double',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'money',
                'user_field_type' => 'Money',
                'db_type' => 'double',
                'accessori_type' => 'double',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'checkbox',
                'user_field_type' => 'CheckBox',
                'db_type' => 'tinyint',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'file',
                'user_field_type' => 'File',
                'db_type' => 'int',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'enum',
                'user_field_type' => 'Enum',
                'db_type' => 'int',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'html',
                'user_field_type' => 'HTML/Text',
                'db_type' => 'longtext',
                'accessori_type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'link_to_user',
                'user_field_type' => 'Link to user',
                'db_type' => 'int',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'link_to_element',
                'user_field_type' => 'Link to element',
                'db_type' => 'int',
                'accessori_type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
