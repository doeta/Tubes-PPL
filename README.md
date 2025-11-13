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

11. **Run development server**

    ```bash
    php artisan serve
    ```

12. **Access application**
    - Open browser: http://127.0.0.1:8000

Jika ingin menggunakan hot reload untuk CSS/JS:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```
