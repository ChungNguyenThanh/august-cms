<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('a_extendblock_entity', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->collation('utf8_unicode_ci')->nullable(false);
            $table->string('table_name', 64)->collation('utf8_unicode_ci')->nullable(false);
            $table->text('description')->collation('utf8_unicode_ci')->nullable();
            $table->string('picture', 255)->collation('utf8_unicode_ci')->nullable();
            $table->char('bizproc', 1)->collation('utf8_unicode_ci')->nullable(false)->default('Y');
            $table->integer('sort')->nullable()->default(500);
            $table->char('rights_mode', 1)->collation('utf8_unicode_ci')->nullable();
            $table->char('is_migrate', 1)->collation('utf8_unicode_ci')->nullable();
            $table->char('extend_block_type_id', 50)->collation('utf8_unicode_ci')->default('');
            $table->integer('version')->default(1);
            $table->char('lock_feature', 1)->collation('utf8_unicode_ci')->default('N');
            $table->timestamp('created_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('modified_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedBigInteger('socnet_group_id')->nullable();
            $table->string('list_namespace', 100)->collation('utf8_unicode_ci')->nullable();
            $table->string('list_component', 250)->collation('utf8_unicode_ci')->nullable();
            $table->string('list_template', 250)->collation('utf8_unicode_ci')->nullable();
            $table->string('element_namespace', 100)->collation('utf8_unicode_ci')->nullable();
            $table->string('element_component', 250)->collation('utf8_unicode_ci')->nullable();
            $table->string('element_template', 250)->collation('utf8_unicode_ci')->nullable();
            $table->string('view_namespace', 100)->collation('utf8_unicode_ci')->nullable();
            $table->string('view_component', 250)->collation('utf8_unicode_ci')->nullable();
            $table->string('view_template', 250)->collation('utf8_unicode_ci')->nullable();
            $table->char('active',1)->collation('utf8_unicode_ci')->nullable();
            $table->char('enable_log',1)->collation('utf8_unicode_ci')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_extendblock_entity');
    }
};
