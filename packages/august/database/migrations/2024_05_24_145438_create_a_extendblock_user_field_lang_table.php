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
        Schema::create('a_extendblock_user_field_lang', function (Blueprint $table) {
            $table->id();
            $table->string('user_field_id', 255)->nullable(false);
            $table->string('lang_id', 2)->collation('utf8_unicode_ci')->nullable(false);
            $table->string('edit_form_label', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('list_column_label', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('list_filter_label', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('error_message_label', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('help_message_label', 255)->collation('utf8_unicode_ci')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_user_field_lang');
    }
};
