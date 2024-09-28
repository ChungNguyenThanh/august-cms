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
        Schema::create('a_extendblock_filter_mode', function (Blueprint $table) {
            $table->id();
            $table->integer('eb_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('filter_mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_filter_mode');
    }
};
