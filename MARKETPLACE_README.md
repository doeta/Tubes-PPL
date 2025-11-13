# Marketplace - E-Commerce Platform

Platform marketplace dengan fitur registrasi dan verifikasi penjual sesuai dengan Software Requirement Specification (SRS).

## 📋 Fitur yang Sudah Diimplementasikan

### ✅ SRS-MartPlace-01: Registrasi Penjual

Fitur registrasi sebagai penjual dengan elemen data:

-   Nama lengkap (untuk akun)
-   Email & Password (untuk login)
-   Nama Toko
-   Deskripsi Singkat Toko
-   Informasi PIC (Person in Charge):
    -   Nama PIC
    -   Email PIC
    -   No. KTP PIC (16 digit)
    -   Alamat sesuai KTP
    -   Upload File KTP (JPG, PNG, PDF - Max 2MB)
-   Alamat Toko Lengkap:
    -   Alamat
    -   Kelurahan
    -   Kecamatan
    -   Kabupaten/Kota
    -   Provinsi

### ✅ SRS-MartPlace-02: Verifikasi Penjual

Sistem verifikasi pendaftaran penjual oleh platform:

-   Dashboard platform untuk melihat pendaftaran yang menunggu verifikasi
-   Halaman detail untuk review informasi penjual
-   Aksi Approve/Reject dengan alasan penolakan
-   Notifikasi email otomatis kepada penjual:
    -   **Email Approve**: Berisi konfirmasi aktivasi akun dan informasi login
    -   **Email Reject**: Berisi alasan penolakan dan informasi kontak
-   Status user otomatis diupdate (active/inactive)

## 🏗️ Struktur Database

### Tabel: users

-   `id` - Primary Key
-   `name` - Nama lengkap
-   `email` - Email untuk login
-   `password` - Password (hashed)
-   `role` - Enum: platform, seller
-   `status` - Enum: active, inactive, pending
-   `email_verified_at`
-   `remember_token`
-   `created_at`, `updated_at`

### Tabel: sellers

-   `id` - Primary Key
-   `user_id` - Foreign Key ke users
-   `nama_toko` - Nama toko
-   `deskripsi_singkat` - Deskripsi toko
-   `nama_pic` - Nama PIC
-   `no_ktp_pic` - Nomor KTP PIC (16 digit)
-   `alamat_ktp_pic` - Alamat sesuai KTP
-   `email_pic` - Email PIC
-   `alamat` - Alamat lengkap toko
-   `nama_kelurahan` - Kelurahan
-   `kecamatan` - Kecamatan
-   `kabupaten_kota` - Kabupaten/Kota
-   `provinsi` - Provinsi
-   `file_ktp_pic` - Path file KTP
-   `verification_status` - Enum: pending, approved, rejected
-   `rejection_reason` - Text alasan penolakan
-   `verified_at` - Timestamp verifikasi
-   `verified_by` - Foreign Key ke users (platform admin)
-   `created_at`, `updated_at`

## 🚀 Cara Setup

### 1. Install Dependencies

```powershell
composer install
npm install
```

### 2. Setup Environment

```powershell
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketplace_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Konfigurasi Email (untuk notifikasi)

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@marketplace.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Jalankan Migration

```powershell
php artisan migrate
```

### 6. Setup Storage untuk Upload File

```powershell
php artisan storage:link
```

### 7. Buat User Platform Admin

```powershell
php artisan db:seed --class=PlatformUserSeeder
```

**Akun Platform Admin:**

-   Email: `admin@marketplace.com`
-   Password: `password`

### 8. Compile Assets

```powershell
npm run dev
```

### 9. Jalankan Server

```powershell
php artisan serve
```

Buka browser: `http://localhost:8000`

## 📱 Penggunaan Aplikasi

### Sebagai Calon Penjual:

1. Buka halaman beranda
2. Klik "Daftar Sebagai Penjual"
3. Isi formulir registrasi lengkap
4. Upload file KTP (JPG, PNG, atau PDF, max 2MB)
5. Submit formulir
6. Tunggu email notifikasi hasil verifikasi (1-3 hari kerja)
7. Jika disetujui, login dengan email dan password yang telah didaftarkan

### Sebagai Platform Admin:

1. Login dengan akun admin (`admin@marketplace.com` / `password`)
2. Otomatis redirect ke halaman "Verifikasi Pendaftaran Penjual"
3. Lihat daftar pendaftaran yang menunggu verifikasi
4. Klik "Review" untuk melihat detail pendaftaran
5. Review semua informasi dan file KTP
6. Klik "Setujui" atau "Tolak" (dengan alasan)
7. Sistem otomatis mengirim email notifikasi ke penjual

## 🔐 Role & Access Control

### Platform Admin

-   Akses ke dashboard verifikasi penjual
-   Dapat approve/reject pendaftaran penjual
-   Dapat melihat detail semua penjual

### Seller (Penjual)

-   Akses ke dashboard penjual (akan dikembangkan)
-   Hanya bisa akses jika status = 'active'
-   Tidak bisa login jika status = 'pending' atau 'inactive'

## 📧 Email Notifications

### Email Approval (Disetujui)

-   Subject: "Verifikasi Penjual Disetujui"
-   Isi: Informasi bahwa akun telah diaktifkan, link login, dan panduan

### Email Rejection (Ditolak)

-   Subject: "Verifikasi Penjual Ditolak"
-   Isi: Alasan penolakan dan informasi untuk mendaftar ulang

## 🗂️ File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── SellerRegistrationController.php
│   │   └── SellerVerificationController.php
│   └── Middleware/
│       └── RedirectIfAuthenticated.php (modified)
├── Models/
│   ├── User.php (modified)
│   └── Seller.php
├── Notifications/
│   └── SellerVerificationNotification.php
└── Policies/
    └── SellerPolicy.php

database/
├── migrations/
│   ├── 2024_11_12_000001_add_role_to_users_table.php
│   └── 2024_11_12_000002_create_sellers_table.php
└── seeders/
    └── PlatformUserSeeder.php

resources/
└── views/
    ├── auth/
    │   ├── register-seller.blade.php
    │   └── register-seller-success.blade.php
    └── platform/
        └── seller-verification/
            ├── index.blade.php
            └── show.blade.php

routes/
└── web.php
```

## 🎯 Routes

### Public Routes

-   `GET /` - Homepage
-   `GET /register-seller` - Form registrasi penjual
-   `POST /register-seller` - Submit registrasi penjual
-   `GET /register-seller/success` - Halaman sukses registrasi
-   `GET /login` - Form login
-   `POST /login` - Submit login

### Platform Routes (auth required, role: platform)

-   `GET /platform/seller-verification` - Daftar pendaftaran pending
-   `GET /platform/seller-verification/{seller}` - Detail pendaftaran
-   `PATCH /platform/seller-verification/{seller}/approve` - Approve pendaftaran
-   `PATCH /platform/seller-verification/{seller}/reject` - Reject pendaftaran

### Seller Routes (auth required, role: seller)

-   `GET /dashboard` - Dashboard penjual

## 📝 Validasi Form

### Registrasi Penjual

-   Semua field mandatory kecuali deskripsi toko
-   Email harus unique
-   No. KTP harus 16 digit dan unique
-   File KTP: JPG, JPEG, PNG, atau PDF, max 2MB
-   Password minimal sesuai default Laravel

## 🔄 Flow Registrasi & Verifikasi

```
1. Penjual mengisi form registrasi
2. Data tersimpan dengan status 'pending'
3. User account dibuat dengan role 'seller' dan status 'pending'
4. Email konfirmasi otomatis (coming soon)
5. Platform admin review di dashboard
6. Platform admin approve/reject:
   - Approve: User status → 'active', email notifikasi dikirim
   - Reject: User status → 'inactive', email dengan alasan dikirim
7. Penjual menerima email dan bisa login (jika approved)
```

## 🛠️ Technology Stack

-   **Framework**: Laravel 11.x
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Database**: MySQL
-   **Authentication**: Laravel Breeze
-   **Email**: Laravel Mail + Queue (optional)
-   **File Storage**: Laravel Storage (public disk)

## 📚 Referensi

-   [Laravel Documentation](https://laravel.com/docs)
-   [Tailwind CSS](https://tailwindcss.com)
-   Software Requirement Specification (SRS) - MartPlace
-   Metodologi: Agile
-   Metoda Pengembangan: ICONIX Process (Object-Oriented)

## 🔜 Fitur yang Akan Dikembangkan

Sesuai SRS, fitur-fitur berikut akan dikembangkan selanjutnya:

-   SRS-MartPlace-03: Upload produk oleh penjual
-   SRS-MartPlace-04: Katalog produk publik dengan rating & komentar
-   SRS-MartPlace-05: Pencarian produk
-   SRS-MartPlace-06: Pemberian komentar dan rating
-   SRS-MartPlace-07: Dashboard platform (grafis)
-   SRS-MartPlace-08: Dashboard penjual (grafis)
-   SRS-MartPlace-09-14: Laporan-laporan (PDF)

## 📄 License

This project is for educational purposes (Tugas Kuliah - Proyek Perangkat Lunak).

## 👨‍💻 Developer

Developed by: [Your Name]
Dosen: Dr. Aris Puji Widodo, MT.
Mata Kuliah: Proyek Perangkat Lunak (3 SKS)
