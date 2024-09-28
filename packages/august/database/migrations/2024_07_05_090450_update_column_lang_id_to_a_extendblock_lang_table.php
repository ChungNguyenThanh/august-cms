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
        Schema::table('a_extendblock_lang', function (Blueprint $table) {
            $table->string('lang_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_extendblock_lang', function (Blueprint $table) {
            $table->integer('lang_id')->change();
        });
    }
};
