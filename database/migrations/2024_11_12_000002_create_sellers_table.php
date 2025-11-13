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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informasi Toko
            $table->string('nama_toko');
            $table->text('deskripsi_singkat')->nullable();
            
            // Informasi PIC (Person in Charge)
            $table->string('nama_pic');
            $table->string('no_ktp_pic', 16);
            $table->string('alamat_ktp_pic');
            $table->string('email_pic');
            
            // Alamat Toko
            $table->text('alamat');
            $table->string('nama_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            
            // File Upload
            $table->string('file_ktp_pic')->nullable();
            
            // Status Verifikasi
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
