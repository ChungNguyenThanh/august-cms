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
        Schema::create('a_extendblock_user_field', function (Blueprint $table) {
            $table->id();
            $table->string('entity_id', 50)->collation('utf8_unicode_ci')->nullable();
            $table->string('field_name', 50)->collation('utf8_unicode_ci')->nullable();
            $table->string('user_type_id', 50)->collation('utf8_unicode_ci')->nullable();
            $table->string('xml_id', 50)->collation('utf8_unicode_ci')->nullable();
            $table->integer('sort')->nullable()->default(500);
            $table->string('multiple', 1)->collation('utf8_unicode_ci')->nullable(false)->default('N');
            $table->string('mandatory', 1)->collation('utf8_unicode_ci')->nullable(false)->default('N');
            $table->string('show_filter', 1)->collation('utf8_unicode_ci')->nullable(false)->default('N');
            $table->string('show_in_list', 1)->collation('utf8_unicode_ci')->nullable(false)->default('Y');
            $table->string('edit_in_list', 1)->collation('utf8_unicode_ci')->nullable(false)->default('Y');
            $table->string('is_searchable', 1)->collation('utf8_unicode_ci')->nullable(false)->default('N');
            $table->text('settings')->collation('utf8_unicode_ci')->nullable();
            $table->string('show_add_form', 1)->collation('utf8_unicode_ci')->nullable();
            $table->string('show_edit_form', 1)->collation('utf8_unicode_ci')->nullable();
            $table->string('add_read_only_field', 1)->collation('utf8_unicode_ci')->nullable();
            $table->string('edit_read_only_field', 1)->collation('utf8_unicode_ci')->nullable();
            $table->string('show_field_preview', 1)->collation('utf8_unicode_ci')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_user_field');
    }
};
