lu jual gwe beli

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Git

## langkah2

1. **Clone repository**

    ```bash
    git clone https://github.com/doeta/Tubes-PPL.git
    cd Tubes-PPL
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Copy environment file**

    ```bash
    cp .env.example .env
    ```

4. **Setup database**

    - Buat database baru (misal: `tubes_ppl`)
    - Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tubes_ppl
    DB_USERNAME=akar
    DB_PASSWORD=rajangoding
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Seed database (optional)**

    ```bash
    php artisan db:seed
    ```

8. **Install NPM dependencies**

    ```bash
    npm install
    ```

9. **Build assets**

    ```bash
    npm run build
    ```

10. **Create storage link (jika ada upload file)**

    ```bash
    php artisan storage:link
    ```

11. **Setup email configuration (untuk notifikasi)**

    Edit file `.env` dan sesuaikan konfigurasi email:

    **Untuk Testing (menggunakan log file):**

    ```env
    MAIL_MAILER=log
    ```

    Email akan tersimpan di `storage/logs/laravel.log`

    **Untuk Production (menggunakan Gmail SMTP):**

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your-email@gmail.com
    MAIL_PASSWORD=your-app-password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="noreply@marketplace.com"
    MAIL_FROM_NAME="MartPlace"
    ```

    **Untuk Testing (menggunakan Mailtrap):**

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=your-mailtrap-username
    MAIL_PASSWORD=your-mailtrap-password
    MAIL_ENCRYPTION=tls
    ```

12. **Setup Queue (untuk email notification)**

    Edit file `.env`:

    ```env
    QUEUE_CONNECTION=database
    ```

    Jalankan queue worker:

    ```bash
    php artisan queue:work
    ```

    Atau untuk development (auto restart saat code berubah):

    ```bash
    php artisan queue:listen
    ```

13. **Run development server**

    ```bash
    php artisan serve
    ```

14. **Access application**
    - Open browser: http://127.0.0.1:8000

## Development Mode (Hot Reload)

Jika ingin menggunakan hot reload untuk CSS/JS:

```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Dev Server
npm run dev

# Terminal 3: Queue Worker (untuk email)
php artisan queue:work
```

## Fitur Email Notification

### Registrasi Penjual

Ketika calon penjual melakukan registrasi, sistem akan:

1. Validasi kelengkapan data administrasi
2. Menyimpan data ke database dengan status `pending`
3. Admin akan menerima notifikasi registrasi baru

### Verifikasi Admin

Admin dapat melakukan verifikasi dengan 2 aksi:

**1. Approve (Terima)**

-   Status seller berubah menjadi `active`
-   Email otomatis dikirim ke seller berisi:
    -   Informasi akun disetujui
    -   Link login ke dashboard
    -   Informasi toko

**2. Reject (Tolak)**

-   Status seller berubah menjadi `suspended`
-   Email otomatis dikirim ke seller berisi:
    -   Alasan penolakan
    -   Informasi untuk mendaftar ulang
    -   Link registrasi

### Email Service

Email menggunakan Laravel Queue untuk mengirim secara asynchronous.
Pastikan queue worker berjalan dengan:

```bash
php artisan queue:work
```
