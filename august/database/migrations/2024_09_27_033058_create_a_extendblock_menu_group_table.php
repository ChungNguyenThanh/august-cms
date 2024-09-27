<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Packages\August\Database\Seeders\AExtendblockMenuGroupSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('a_extendblock_menu_group', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable("a_extendblock_menu_group")){
            require base_path('packages/august/database/seeders/AExtendblockMenuGroupSeeder.php');
            $seeder = new AExtendblockMenuGroupSeeder();
            $seeder->run();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_menu_group');
    }
};
