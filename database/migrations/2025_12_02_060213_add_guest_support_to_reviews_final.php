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
        Schema::table('reviews', function (Blueprint $table) {
            // Check if columns already exist before adding
            if (!Schema::hasColumn('reviews', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('reviews', 'guest_phone')) {
                $table->string('guest_phone', 20)->nullable()->after('guest_name');
            }
            if (!Schema::hasColumn('reviews', 'guest_email')) {
                $table->string('guest_email')->nullable()->after('guest_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_phone', 'guest_email']);
        });
    }
};
