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
        Schema::create('a_extendblock_user_field_type', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('user_field_type')->nullable();
            $table->string('db_type')->nullable();
            $table->string('accessori_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_user_field_type');
    }
};
