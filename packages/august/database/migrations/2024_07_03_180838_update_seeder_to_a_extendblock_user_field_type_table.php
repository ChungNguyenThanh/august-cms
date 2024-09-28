<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Packages\August\Database\Seeders\AExtendblockUserFieldTypeSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('a_extendblock_user_field_type', function (Blueprint $table) {
            //
        });

        require base_path('packages/august/database/seeders/AExtendblockUserFieldTypeSeeder.php');
        $seeder = new AExtendblockUserFieldTypeSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_extendblock_user_field_type', function (Blueprint $table) {
            //
        });
    }
};
