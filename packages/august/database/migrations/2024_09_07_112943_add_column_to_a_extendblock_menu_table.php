<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('a_extendblock_menu', function (Blueprint $table) {
            $table->string('menu_title')->nullable()->after('menu_id');
            $table->integer('menu_sort')->nullable();
            $table->string('menu_group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_extendblock_menu', function (Blueprint $table) {
            //
        });
    }
};
