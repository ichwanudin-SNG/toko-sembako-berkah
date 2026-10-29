<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes — Toko Sembako Berkah (Full-Stack MVC)
|--------------------------------------------------------------------------
*/

// Halaman Beranda Utama (Arahkan ke Beranda Produk atau Dashboard)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('produk.index');
})->name('home');

// Autentikasi Tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
});

// Katalog Produk & Kategori Publik (Sesuai Screenshot User)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

// Area Terproteksi Login
Route::middleware('auth')->group(function () {
    // Logout & Profil
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');

    // Dashboard Finansial & Operasional
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi Kasir (Bisa diakses Pemilik & Kasir)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/baru', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/cetak', [TransaksiController::class, 'printReceipt'])->name('transaksi.print');

    // Khusus Hak Akses Pemilik (Role-Based Access Policy CPMK4)
    Route::middleware('role:pemilik')->group(function () {
        // Kelola Produk (Tambah, Edit, Hapus)
        Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // Kelola Kategori (Tambah, Edit, Hapus)
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Laporan Keuangan & Finansial (Laba Rugi)
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });
});
