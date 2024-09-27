<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\August\Database\Seeders\AExtendblockUserRoleRelationSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_role_relation', function (Blueprint $table) {
            //
        });

        require base_path('packages/august/database/seeders/AExtendblockUserRoleRelationSeeder.php');
        $seeder = new AExtendblockUserRoleRelationSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_role_relation', function (Blueprint $table) {
            //
        });
    }
};
