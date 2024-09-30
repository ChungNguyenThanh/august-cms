<?php

namespace Packages\August\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Package\August\Models\AExtendblockUserRole;
use Package\August\Models\AExtendblockUsers;

class AExtendblockUserRoleRelationSeeder extends Seeder
{
    public function run() {
        $user = AExtendblockUsers::where("email", "superadmin@gmail.com")->first();
        $role = AExtendblockUserRole::where('code', 'administrator')->first();

        if ($user && $role) {
            DB::table('a_extendblock_user_role_relation')->insert([
                [
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}