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
        Schema::table('a_extendblock_file', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('extension')->nullable()->after('path');
            $table->string('author')->nullable()->after('extension');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_extendblock_file', function (Blueprint $table) {
            //
        });
    }
};
