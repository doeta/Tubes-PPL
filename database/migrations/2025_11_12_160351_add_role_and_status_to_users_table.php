<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add temporary columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_temp')->nullable()->after('role');
            $table->string('status_temp')->nullable()->after('status');
        });
        
        // Step 2: Copy data with mapping
        DB::table('users')->update([
            'role_temp' => DB::raw("CASE 
                WHEN role = 'platform' THEN 'admin' 
                WHEN role = 'seller' THEN 'seller'
                ELSE 'buyer' 
            END"),
            'status_temp' => DB::raw("CASE 
                WHEN status = 'inactive' THEN 'suspended'
                WHEN status = 'pending' THEN 'pending'
                ELSE 'active'
            END")
        ]);
        
        // Step 3: Drop old columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
        
        // Step 4: Rename temp columns
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_temp', 'role');
            $table->renameColumn('status_temp', 'status');
        });
        
        // Step 5: Modify to ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'seller', 'buyer') DEFAULT 'buyer'");
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'pending', 'suspended') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('platform', 'seller') DEFAULT 'seller'");
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive', 'pending') DEFAULT 'pending'");
    }
};
