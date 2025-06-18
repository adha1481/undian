# 🎯 Aplikasi Undian Hadiah - Laravel 10

Aplikasi undian hadiah yang profesional dan interaktif, dibangun menggunakan Laravel 10 dengan antarmuka yang modern dan user-friendly. Aplikasi ini menyediakan sistem undian yang fair dengan animasi yang menarik dan pengelolaan data yang komprehensif.

## ✨ Fitur Utama

### 🎪 Sistem Undian Interaktif

-   **Animasi Real-time**: Nama peserta berganti secara cepat dengan animasi yang smooth
-   **Tombol Stop**: Sistem berhenti saat tombol ditekan untuk memilih pemenang
-   **Efek Visual**: Konfetti dan animasi celebrasi saat pemenang dipilih
-   **Responsive Design**: Tampilan yang optimal di semua perangkat

### 👥 Manajemen Peserta

-   **Pendaftaran Mudah**: Form pendaftaran dengan validasi lengkap
-   **CRUD Lengkap**: Create, Read, Update, Delete peserta
-   **Status Tracking**: Pelacakan status pemenang otomatis
-   **Data Validation**: Validasi input dengan feedback real-time

### 🏆 Manajemen Hadiah

-   **CRUD Hadiah**: Kelola hadiah dengan mudah
-   **Multiple Quantities**: Satu hadiah bisa memiliki beberapa unit
-   **Status Management**: Aktif/nonaktif hadiah untuk undian
-   **Progress Tracking**: Lihat progress hadiah yang sudah terbagi

### 🎉 Sistem Pemenang

-   **One-Time Winner**: Setiap peserta hanya bisa menang 1 kali
-   **Auto Update**: Status peserta dan hadiah terupdate otomatis
-   **Winner Gallery**: Galeri pemenang dengan ranking
-   **Hall of Fame**: Penghargaan untuk pemenang teratas

## 🛠 Teknologi yang Digunakan

-   **Backend**: Laravel 10 (PHP)
-   **Frontend**: Bootstrap 5, jQuery, CSS3
-   **Database**: SQLite (development), MySQL (production ready)
-   **Icons**: Font Awesome 6
-   **Fonts**: Google Fonts (Poppins)
-   **Animations**: CSS3 Animations & Transitions

## 📋 Persyaratan Sistem

-   PHP >= 8.1
-   Composer
-   SQLite (untuk development)
-   Web Browser modern (Chrome, Firefox, Safari, Edge)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd undian
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

```bash
# Buat file database SQLite
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# Isi data sample (opsional)
php artisan db:seed
```

### 5. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## 📊 Struktur Database

### Tabel Participants

```sql
- id (Primary Key)
- name (Nama peserta)
- address (Alamat lengkap)
- has_won (Status pemenang: boolean)
- created_at, updated_at
```

### Tabel Prizes

```sql
- id (Primary Key)
- name (Nama hadiah)
- quantity (Jumlah hadiah)
- winners_count (Jumlah pemenang saat ini)
- description (Deskripsi hadiah)
- is_active (Status aktif: boolean)
- created_at, updated_at
```

### Tabel Winners

```sql
- id (Primary Key)
- participant_id (Foreign Key ke participants)
- prize_id (Foreign Key ke prizes)
- won_at (Tanggal & waktu menang)
- created_at, updated_at
```

## 🎮 Cara Penggunaan

### 1. Pendaftaran Peserta

1. Klik menu **"Peserta"**
2. Klik **"Tambah Peserta"**
3. Isi nama lengkap dan alamat
4. Klik **"Daftarkan Peserta"**

### 2. Menambah Hadiah

1. Klik menu **"Hadiah"**
2. Klik **"Tambah Hadiah"**
3. Isi detail hadiah (nama, jumlah, deskripsi)
4. Pastikan status "Aktif" untuk undian
5. Klik **"Simpan Hadiah"**

### 3. Menjalankan Undian

1. Klik menu **"Undian"**
2. Pilih hadiah dari dropdown
3. Klik **"Mulai Undian"**
4. Tunggu animasi nama peserta berganti
5. Klik **"Berhenti & Pilih Pemenang"** saat siap
6. Sistem akan menampilkan pemenang dengan animasi

### 4. Melihat Pemenang

1. Klik menu **"Pemenang"**
2. Lihat daftar semua pemenang dengan ranking
3. Pemenang teratas ditampilkan di Hall of Fame

## 🔧 Fitur Administrasi

### Reset Sistem Undian

Untuk keperluan testing atau demo baru:

1. Di halaman Undian, klik **"Reset Semua Data"**
2. Konfirmasi reset
3. Semua status pemenang akan direset

### Manajemen Data

-   **Edit Peserta**: Ubah data peserta (kecuali yang sudah menang)
-   **Edit Hadiah**: Ubah detail hadiah (jumlah tidak boleh kurang dari pemenang)
-   **Hapus Data**: Hanya data tanpa pemenang yang bisa dihapus

## 🎨 Kustomisasi UI

### Warna Tema

Ubah variabel CSS di `resources/views/layouts/app.blade.php`:

```css
--primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
--success-color: #56ab2f;
--warning-color: #f39c12;
```

### Animasi

Sesuaikan kecepatan animasi di file JavaScript:

```javascript
// Kecepatan ganti nama (ms)
lotteryInterval = setInterval(function () {
    // ...
}, 100); // Ubah nilai ini untuk mengatur kecepatan
```

## 🔒 Keamanan

-   **CSRF Protection**: Semua form dilindungi CSRF token
-   **Input Validation**: Validasi server-side dan client-side
-   **SQL Injection Prevention**: Menggunakan Eloquent ORM
-   **XSS Protection**: Auto-escaping di Blade templates

## 📱 Responsive Design

Aplikasi telah dioptimasi untuk:

-   **Desktop**: Full feature dengan layout 2 kolom
-   **Tablet**: Layout adaptif dengan navigation collapse
-   **Mobile**: Single column layout dengan touch-friendly buttons

## 🐛 Troubleshooting

### Database Issues

```bash
# Reset database
php artisan migrate:fresh --seed
```

### Permission Issues

```bash
# Fix storage permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Cache Issues

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📈 Pengembangan Lebih Lanjut

### Fitur yang Bisa Ditambahkan

-   **Multi-tenant**: Support multiple events
-   **Email Notifications**: Kirim email ke pemenang
-   **Export Data**: Export pemenang ke Excel/PDF
-   **User Authentication**: Login system untuk admin
-   **API Integration**: REST API untuk mobile app
-   **Real-time Updates**: WebSocket untuk live updates

### Deployment ke Production

1. Setup database MySQL/PostgreSQL
2. Configure web server (Apache/Nginx)
3. Setup SSL certificate
4. Configure caching (Redis/Memcached)
5. Setup queue workers untuk email

## 👨‍💻 Kontributor

Aplikasi ini dikembangkan dengan ❤️ menggunakan Laravel 10 dan teknologi web modern.

## 📄 Lisensi

Aplikasi ini dikembangkan untuk keperluan edukasi dan pembelajaran. Silakan gunakan dan modifikasi sesuai kebutuhan.

---

**🎊 Selamat menggunakan Aplikasi Undian Hadiah! Semoga beruntung! 🎊**
