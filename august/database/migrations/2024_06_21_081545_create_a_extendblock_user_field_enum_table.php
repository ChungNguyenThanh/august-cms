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
        Schema::create('a_extendblock_user_field_enum', function (Blueprint $table) {
            $table->id();
            $table->integer('user_field_id')->nullable();
            $table->string('value');
            $table->bigInteger('def')->length(1)->default(0);
            $table->integer('sort')->nullable()->default(500);
            $table->string('xml_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_user_field_enum');
    }
};
