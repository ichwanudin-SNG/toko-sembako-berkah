# Toko Sembako Berkah — Sistem Manajemen Operasional & Finansial (Full-Stack Laravel)

> **UAS Web Application Development — Universitas Cakrawala**  
> Studi Kasus: **Sistem Manajemen Inventaris & E-Commerce / POS UMKM Lokal**  
> Arsitektur: **Model-View-Controller (MVC) Server-Side Framework Laravel**

---

## 👤 Identitas Mahasiswa Pengembang

| Keterangan | Data Mahasiswa |
| :--- | :--- |
| **Nama Lengkap** | **Ichwanudin** |
| **NIM** | **25120300018** |
| **Mata Kuliah** | Web Application Development |
| **Perguruan Tinggi** | Universitas Cakrawala |
| **Repositori GitHub** | [https://github.com/ichwanudin-SNG/toko-sembako-berkah](https://github.com/ichwanudin-SNG/toko-sembako-berkah) |

---

## 📌 Ringkasan Proyek
**Toko Sembako Berkah** adalah aplikasi web dinamis berbasis *server-side* yang dibangun menggunakan **Framework Laravel 12** dan basis data relasional **MySQL**. Sistem ini dirancang untuk mendigitalkan operasional toko sembako grosir dan eceran, mulai dari manajemen inventaris barang, pemantauan stok menipis secara *real-time*, modul kasir penjualan (*Point of Sale* / POS) dengan kalkulasi otomatis, pencetakan struk transaksi, hingga pembuatan laporan finansial (omset, HPP, dan estimasi laba bersih).

Aplikasi mengimplementasikan kontrol akses berbasis peran (*Role-Based Access Control*), pemisahan hak akses antara **Pemilik Toko (Admin)** dan **Kasir**, serta perlindungan keamanan web modern (CSRF Protection, sanitasi input terhadap XSS, dan parameterized queries anti SQL Injection).

---

## 🛠️ Tech Stack & Alat Pengembangan
* **Bahasa Pemrograman:** PHP 8.2+
* **Framework Backend:** Laravel 12.x (Arsitektur MVC)
* **Basis Data:** MySQL 8.x / MariaDB Relasional
* **Template Engine:** Blade Templating Engine
* **Styling & UI:** Clean Semantic HTML5 & CSS3 (Tema Hijau Khas Toko Sembako Berkah)
* **ORM:** Eloquent ORM
* **Server Lokal:** PHP Built-in Server & XAMPP (Apache/MySQL)

---

## 🚀 Fitur Utama Aplikasi

### 1. Perancangan Database Relasional (CPMK1)
* Menggunakan 5 tabel utama yang saling berelasi:
  1. `users`: Menyimpan data akun pengguna dan perannya (`pemilik` vs `kasir`).
  2. `kategoris`: Klasifikasi barang sembako (Beras, Minyak, Gula, Tepung, dll).
  3. `produks`: Data barang, SKU/kode barang, stok persediaan, harga beli (modal), harga jual, satuan unit, dan foto produk (berelasi ke `kategoris`).
  4. `transaksis`: Rekam faktur nota penjualan, total tagihan, nominal bayar, dan uang kembalian (berelasi ke `users`).
  5. `detail_transaksis`: Rincian item barang per transaksi dengan harga saat transaksi dan subtotal (berelasi ke `transaksis` dan `produks`).

### 2. Implementasi CRUD & Logika Backend (CPMK2, CPMK3)
* **Katalog Produk & Foto:** Pencarian nama/kode produk *real-time*, filter per kategori, pagination, visual thumbnail barang, validasi harga jual tidak boleh lebih kecil dari harga beli.
* **Master Kategori:** Tambah, edit, dan hapus kategori dengan pengaman relasi (kategori yang masih memiliki produk tidak dapat dihapus sembarangan).
* **Modul Kasir (POS):** Pemilihan produk satu-klik dilengkapi gambar, hitung total belanja otomatis, tombol cepat uang pecahan (*quick cash*), hitung uang kembalian, validasi stok minimum, dan pengurangan stok otomatis menggunakan `DB::transaction`.
* **Cetak Struk:** Halaman struk thermal 80mm yang siap dicetak langsung (`window.print()`).
* **Laporan Finansial:** Laporan penjualan dengan filter tanggal, rekapitulasi omset, perhitungan Harga Pokok Penjualan (HPP), dan estimasi laba bersih toko.
* **Dashboard Metrik:** Kartu ringkasan finansial (omset hari ini, modal inventaris, keuntungan kotor) dan tabel peringatan stok menipis (&le; 5 unit).

### 3. Keamanan Web & Manajemen Sesi (CPMK4)
* **Autentikasi Pengguna:** Sistem Login, Register, Logout menggunakan session terenkripsi server-side.
* **Role-Based Access Control (RBAC):**
  * `pemilik`: Akses penuh ke seluruh fitur (Kelola Produk, Kelola Kategori, Laporan Laba Rugi, Transaksi, Dashboard).
  * `kasir`: Akses terbatas untuk melayani transaksi kasir, melihat daftar produk dan stok, serta melihat profil.
* **Proteksi CSRF:** Menggunakan token `@csrf` pada setiap pengiriman formulir HTTP POST/PUT/DELETE.
* **Sanitasi XSS:** Penggunaan sintaks Blade `{{ $variable }}` untuk meng-escape output HTML berbahaya secara otomatis.
* **Pencegahan SQL Injection:** Seluruh manipulasi data menggunakan **Eloquent ORM** yang otomatis menerapkan *PDO Parameterized Queries*.

---

## 🔑 Informasi Akun Pengguna (Demo Akses)

Setelah proses *seeding*, sistem telah menyediakan dua akun bawaan untuk pengujian:

| Peran (Role) | Username | Password | Email | Cakupan Hak Akses |
| :--- | :--- | :--- | :--- | :--- |
| **Pemilik (Admin)** | `pemilik` | `password123` | `pemilik@sembako.com` | Akses Penuh: CRUD Produk, Kategori, Laporan Finansial, Dashboard |
| **Kasir** | `kasir` | `password123` | `kasir@sembako.com` | Transaksi Kasir POS, Cetak Struk, Lihat Stok Produk |

---

## 💻 Panduan Instalasi & Menjalankan di Komputer Lokal

### Prasyarat
* PHP >= 8.2 (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `zip` aktif).
* MySQL Database (misal via XAMPP).
* Composer terpasang.

### Langkah-Langkah:

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/ichwanudin-SNG/toko-sembako-berkah.git
   cd toko-sembako-berkah
   ```

2. **Pasang Dependensi:**
   ```bash
   composer install
   ```

3. **Pastikan Konfigurasi Database `.env`:**
   Salin `.env.example` menjadi `.env` dan sesuaikan kredensial MySQL lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=toko_sembako_berkah
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key & Hubungkan Storage:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

5. **Jalankan Migrasi & Seeder Database:**
   Perintah ini akan membuat struktur 5 tabel relasional dan mengisi data contoh sembako lengkap:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Web Server Lokal:**
   ```bash
   php artisan serve --port=8000
   ```

7. **Akses Aplikasi di Browser:**
   Buka alamat berikut di browser:
   * **Katalog Produk:** [http://127.0.0.1:8000/produk](http://127.0.0.1:8000/produk)
   * **Halaman Login:** [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

---

## 📁 Struktur Direktori MVC (Model-View-Controller)

```text
toko-sembako-berkah/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Controller Login, Register, Logout, Profile
│   │   │   ├── DashboardController.php  # Controller Ringkasan Finansial & Metrik
│   │   │   ├── ProdukController.php     # Controller CRUD Master Produk Sembako
│   │   │   ├── KategoriController.php   # Controller CRUD Kategori
│   │   │   ├── TransaksiController.php  # Controller POS Kasir, Checkout & Struk
│   │   │   └── LaporanController.php    # Controller Laporan Omset & Laba Rugi
│   │   └── Middleware/
│   │       └── RoleMiddleware.php       # Filter Hak Akses (Pemilik vs Kasir)
│   └── Models/
│       ├── User.php                     # Model Pengguna & Role
│       ├── Kategori.php                 # Model Kategori Sembako
│       ├── Produk.php                   # Model Barang Sembako & Stok
│       ├── Transaksi.php                # Model Faktur Transaksi Penjualan
│       └── DetailTransaksi.php          # Model Item Transaksi
├── database/
│   ├── migrations/                      # 5 Script Migrasi Tabel Relasional
│   └── seeders/
│       └── DatabaseSeeder.php           # Data Awal Akun, Kategori, Produk & Transaksi
├── public/
│   ├── css/
│   │   └── style.css                    # Styling Hijau Khas Toko Sembako Berkah
│   └── images/produk/                   # Asset Ilustrasi Gambar Sembako
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php            # Layout Master Navigasi & Footer
│       ├── auth/                        # View Login, Register, Profil
│       ├── dashboard/                   # View Dashboard Finansial
│       ├── produk/                      # View Daftar Produk, Tambah, Edit
│       ├── kategori/                    # View Manajemen Kategori
│       ├── transaksi/                   # View Riwayat, POS Kasir, Detail & Print
│       └── laporan/                     # View Laporan Keuangan Periode
├── routes/
│   └── web.php                          # Deklarasi Routing MVC & Proteksi Middleware
├── _legacy_python/                      # Arsip source code versi Python sebelumnya
├── .env.example                         # Contoh Konfigurasi Environment
├── toko_sembako_berkah.sql              # File Ekspor Database MySQL
├── DOKUMEN_LAPORAN_DAN_ESAI_UAS.md      # Materi ERD, Flowchart, dan Jawaban Esai Video
└── README.md                            # Dokumentasi Utama Repositori
```

---

## 🌐 Panduan Deployment ke Cloud Hosting Publik (CPMK5)
Aplikasi ini siap di-deploy ke penyedia cloud gratis atau berbayar seperti **Render**, **Railway**, atau **VPS**:
1. Buat database MySQL di cloud (misalnya menggunakan **Railway** atau **Aiven MySQL**).
2. Hubungkan repositori GitHub ini ke **Render / Railway Web Service**.
3. Set variabel environment di dashboard cloud (`APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
4. Jalankan `php artisan migrate --force --seed` pada tahap *build command*.

---
*(Repositori ini disusun secara orisinal dan mandiri untuk memenuhi seluruh indikator penilaian UAS Web Application Development — Universitas Cakrawala)*
