# 🛒 Toko Sembako Berkah — Sistem Manajemen Penjualan

Sistem manajemen toko sembako berbasis web yang dibangun untuk memudahkan pencatatan produk, kategori, pengguna, dan transaksi penjualan sehari-hari.

---

## ✨ Fitur Utama

| No | Fitur | Keterangan |
|---|---|---|
| 1 | 🔐 Autentikasi | Daftar, Masuk, dan Keluar dengan JWT |
| 2 | 📦 Manajemen Produk | Tambah, Lihat, Ubah, Hapus data barang |
| 3 | 🗂️ Kategori Produk | Pengelompokan barang agar teratur |
| 4 | 💰 Transaksi Penjualan | Catat penjualan, hitung total & kembalian otomatis |
| 5 | 📊 Profil Pengguna | Informasi akun yang sedang digunakan |
| 6 | 📱 Tampilan Responsif | Bisa dibuka di laptop maupun HP |

---

## 🛠️ Teknologi yang Digunakan

**Backend:** Python 3, FastAPI, SQLAlchemy, Pydantic, Passlib, JWT, SQLite  
**Frontend:** HTML5, CSS3, JavaScript Vanilla, Live Server

---

## 📂 Struktur Lengkap Proyek
toko-sembako-berkah/
├── backend/
│ ├── database.py
│ ├── main.py
│ ├── requirements.txt
│ ├── models/
│ │ ├── init.py
│ │ ├── pengguna.py
│ │ ├── kategori.py
│ │ ├── produk.py
│ │ ├── transaksi.py
│ │ └── detail_transaksi.py
│ ├── schemas/
│ │ ├── init.py
│ │ ├── pengguna.py
│ │ ├── kategori.py
│ │ ├── produk.py
│ │ ├── transaksi.py
│ │ └── detail_transaksi.py
│ ├── routes/
│ │ ├── init.py
│ │ ├── auth.py
│ │ ├── kategori.py
│ │ ├── produk.py
│ │ └── transaksi.py
│ └── utils/
│ ├── init.py
│ └── security.py
├── frontend/
│ ├── index.html
│ ├── produk.html
│ ├── kategori.html
│ ├── transaksi.html
│ ├── login.html
│ ├── daftar.html
│ ├── profil.html
│ ├── css/
│ │ └── style.css
│ └── js/
│ └── app.js
├── .gitignore
└── README.md

---

## 🚀 Cara Menjalankan

**1. Pasang Kebutuhan Backend:**
```bash
cd backend
pip install fastapi uvicorn sqlalchemy pydantic "pydantic[email]" python-jose passlib bcrypt
2. Jalankan Server API:
bash
uvicorn main:app --reload
API: http://127.0.0.1:8000
Docs: http://127.0.0.1:8000/docs
3. Jalankan Tampilan Web:
Buka folder frontend di VS Code
Klik kanan index.html → Open with Live Server
Tampilan: http://127.0.0.1:5500/index.html
📖 Cara Pakai
Buka halaman utama → klik Daftar → buat akun baru
Isi data lengkap → simpan
Klik Masuk → pakai akun yang dibuat
Mulai kelola kategori, produk, dan catat penjualan
🔑 Daftar API
Tabel
Metode	Alamat	Keterangan
POST	/api/auth/daftar	Daftar pengguna baru
POST	/api/auth/masuk	Masuk & dapat token
GET	/api/auth/profil	Lihat profil
GET	/api/kategori/	Semua kategori
POST	/api/kategori/	Tambah kategori
PUT	/api/kategori/{id}	Ubah kategori
DELETE	/api/kategori/{id}	Hapus kategori
GET	/api/produk/	Semua produk
POST	/api/produk/	Tambah produk
PUT	/api/produk/{id}	Ubah produk
DELETE	/api/produk/{id}	Hapus produk
GET	/api/transaksi/	Riwayat penjualan
POST	/api/transaksi/	Catat penjualan baru
GET	/api/transaksi/{id}	Detail transaksi
📝 Catatan
Basis data toko.db dibuat otomatis saat pertama kali dijalankan
Token berlaku 8 jam
Dikembangkan sebagai tugas mata kuliah Pemrograman Web / Sistem Informasi
Pengembangan selanjutnya: laporan, grafik, hak akses, cetak struk
👤 Pengembang
Tabel
Keterangan	Isi
Nama	Ichwanudin
NIM	—
Mata Kuliah	—
Kampus	—
"Toko Sembako Berkah — Membantu Mengelola Usaha dengan Lebih Mudah" 💚
plaintext

---

Salin semua dari kotak di atas, simpan jadi `README.md`, lalu jalankan:
```bash
git add README.md
git commit -m "Dokumentasi lengkap"
git push
