<?php

/**
 * Test script untuk memverifikasi email notification
 * Jalankan dengan: php test-email.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Notifications\SellerVerificationNotification;
use Illuminate\Support\Facades\DB;

echo "=== Test Email Notification ===\n\n";

// Cari seller pertama
$user = User::where('role', 'seller')->with('seller')->first();

if (!$user || !$user->seller) {
    echo "❌ Tidak ada seller di database!\n";
    echo "Silakan daftarkan seller terlebih dahulu.\n";
    exit(1);
}

echo "✓ Seller ditemukan:\n";
echo "  - Nama: {$user->name}\n";
echo "  - Email: {$user->email}\n";
echo "  - Toko: {$user->seller->nama_toko}\n\n";

echo "Mengirim test email APPROVAL...\n";
try {
    $user->notify(new SellerVerificationNotification($user->seller, 'approved'));
    echo "✓ Email approval berhasil di-queue!\n\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

echo "Mengirim test email REJECTION...\n";
try {
    $user->notify(new SellerVerificationNotification($user->seller, 'rejected', 'Dokumen KTP tidak jelas'));
    echo "✓ Email rejection berhasil di-queue!\n\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Cek jobs di queue
$jobsCount = DB::table('jobs')->count();
echo "📋 Total jobs di queue: {$jobsCount}\n\n";

if ($jobsCount > 0) {
    echo "✅ Email sudah masuk ke queue!\n";
    echo "Pastikan queue worker berjalan dengan command:\n";
    echo "php artisan queue:work --tries=3 --timeout=90\n";
} else {
    echo "⚠️  Tidak ada jobs di queue. Periksa konfigurasi QUEUE_CONNECTION di .env\n";
}

echo "\n=== Test Selesai ===\n";
