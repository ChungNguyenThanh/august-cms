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
        Schema::create('a_extendblock_entity_lang', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('block_id')->unique()->nullable();
            $table->string('lid', 2)->collation('utf8_unicode_ci')->nullable(false);
            $table->string('name', 255)->collation('utf8_unicode_ci')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_entity_lang');
    }
};
