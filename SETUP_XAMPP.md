# 🎯 Setup Undian Tabungan Simpedes BRI dengan XAMPP

## 📋 Prerequisites

-   XAMPP sudah terinstall
-   PHP 8.1 atau lebih tinggi
-   Composer terinstall

## 🚀 Langkah Setup

### 1. Konfigurasi Database di XAMPP

1. **Buka XAMPP Control Panel**
2. **Start Apache dan MySQL**
3. **Klik "Admin" pada MySQL untuk membuka phpMyAdmin**
4. **Buat database baru:**
    - Nama database: `undian_bri`
    - Collation: `utf8mb4_unicode_ci`

### 2. Konfigurasi Environment Laravel

Edit file `.env` dan pastikan konfigurasi database seperti ini:

```env
APP_NAME="Undian Tabungan Simpedes BRI"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=undian_bri
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Jika XAMPP MySQL menggunakan password, isi field `DB_PASSWORD` dengan password yang sesuai.

### 3. Install Dependencies dan Migrasi

```bash
# Install dependencies
composer install

# Generate application key (jika belum)
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Jalankan seeder untuk data sample
php artisan db:seed
```

### 4. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: `http://localhost:8000`

## 🎨 Theme BRI yang Sudah Diimplementasikan

### Warna Brand BRI

-   **Primary Blue**: #003d7a (BRI Corporate Blue)
-   **Secondary Blue**: #0056b3
-   **Success Green**: #28a745
-   **Warning Yellow**: #ffc107

### Fitur UI BRI

-   ✅ Header dengan logo dan branding BRI
-   ✅ Slogan: "Menabung Hari Ini, Beruntung Selamanya"
-   ✅ Animasi dengan kecepatan diperlambat (250ms)
-   ✅ Efek confetti saat pemenang dipilih
-   ✅ Design card dengan gradient BRI
-   ✅ Icon bank dan simbol keuangan

## 🔧 Troubleshooting

### Error: "Connection refused"

-   Pastikan MySQL service di XAMPP sudah running
-   Cek port 3306 tidak digunakan aplikasi lain

### Error: "Database doesn't exist"

-   Pastikan database `undian_bri` sudah dibuat di phpMyAdmin
-   Cek nama database di file `.env` sesuai

### Error: "Access denied"

-   Pastikan username/password database benar
-   Default XAMPP: username=`root`, password=kosong

### Warning PHP Extensions

Warning tentang `php_zip.dll` dan `imagick` bisa diabaikan, tidak mempengaruhi aplikasi undian.

## 📊 Data Sample yang Tersedia

Seeder akan membuat:

-   **15 Peserta** dengan nama dan alamat Indonesia
-   **10 Hadiah** menarik termasuk:
    -   iPhone 15 Pro Max
    -   Gaming Laptop ASUS ROG
    -   Samsung Galaxy S24 Ultra
    -   Nintendo Switch OLED
    -   Voucher belanja dan hadiah lainnya

## 🎯 Fitur Khusus BRI

1. **Animasi Diperlambat**: Nama peserta berganti setiap 250ms (lebih mudah dibaca)
2. **Theme Konsisten**: Semua elemen menggunakan warna dan style BRI
3. **Professional Layout**: Desain yang cocok untuk acara resmi bank
4. **Mobile Responsive**: Bisa digunakan di tablet/proyektor untuk acara besar

## 📱 Tips Penggunaan untuk Acara

1. **Proyektor/TV Besar**: Buka di fullscreen mode untuk visibilitas maksimal
2. **Sound System**: Bisa tambahkan efek suara celebration
3. **Backup Data**: Export data pemenang sebelum reset
4. **Multiple Rounds**: Gunakan tombol "Undian Selanjutnya" untuk putaran berganda

---

**Selamat menggunakan Sistem Undian Tabungan Simpedes BRI! 🎉**
