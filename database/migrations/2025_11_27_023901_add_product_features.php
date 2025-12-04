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
        // Table untuk review produk
        // SRS-MartPlace-06: Pengunjung tidak perlu login untuk review
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nama pengunjung
            $table->string('phone', 20); // Nomor HP pengunjung
            $table->string('email'); // Email pengunjung
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Update products table - tambah kolom yang kurang
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('slug');
            $table->string('brand')->nullable()->after('name');
            $table->decimal('weight', 8, 2)->nullable()->after('price'); // gram
            $table->string('condition')->default('new')->after('weight'); // new/used
            $table->integer('min_order')->default(1)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'brand', 'weight', 'condition', 'min_order']);
        });
    }
};
