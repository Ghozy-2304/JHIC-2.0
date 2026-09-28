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
        Schema::table('career_jobs', function (Blueprint $table) {
            $table->string('source_platform', 60)->nullable()->default('Mitra Resmi IDN')->after('apply_url');
            $table->timestamp('posted_at')->nullable()->after('post_time_category');
            $table->timestamp('expires_at')->nullable()->after('posted_at');
            $table->text('requirements')->nullable()->after('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_jobs', function (Blueprint $table) {
            $table->dropColumn(['source_platform', 'posted_at', 'expires_at', 'requirements']);
        });
    }
};
