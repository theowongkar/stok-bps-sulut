# 🏷️ Stok BPS Sulut

Website Badan Pusat Statistik (BPS), Sulawesi Utara. Situs web ini dirancang khusus untuk menyederhanakan manajemen inventaris di gudang dan agensi.

## ✨ Fitur

-   👤 Manajemen Pengguna (CRUD User)
-   🧑🏻‍💼 Manajemen Pegawai (CRUD Employee)
-   📦 Manajemen Barang (CRUD Item)
-   📥 Manajemen Barang Masuk (CRUD Stock In)
-   📤 Manajemen Barang Keluar (CRUD Stock Out)
-   📊 Dashboard Admin dan Statistik

## ⚙️ Teknologi

-   Laravel 12
-   PHP 8.3
-   Tailwind CSS
-   Alpine.js
-   MySQL
-   Bootstrap Icon
-   LangCommon

## 🛠️ Instalasi & Setup

1. Clone repository:

    ```bash
    git clone https://github.com/theowongkar/stok-bps-sulut.git
    cd stok-bps-sulut
    ```

2. Install dependency:

    ```bash
    composer install
    npm install && npm run build
    ```

3. Salin file `.env`:

    ```bash
    cp .env.example .env
    ```

4. Atur konfigurasi `.env` (database, mail, dsb)

5. Generate key dan migrasi database:

    ```bash
    php artisan key:generate
    php artisan storage:link
    php artisan migrate:fresh --seed
    ```

6. Jalankan server lokal:

    ```bash
    php artisan serve
    ```

7. Buka browser dan akses http://127.0.0.1:8000

## 👥 Role & Akses

| Role  | Akses                                               |
| ----- | --------------------------------------------------- |
| Admin | CRUD data user, employee, item, stock in, stock out |

## 📎 Catatan Tambahan

-   Pastikan folder `storage` dan `bootstrap/cache` writable.
