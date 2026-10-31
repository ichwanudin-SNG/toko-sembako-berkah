<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;

/*
|--------------------------------------------------------------------------
| Web Routes — Toko Sembako Berkah (Full-Stack MVC)
|--------------------------------------------------------------------------
*/

// Halaman Beranda Utama
Route::get('/', function () {
    if (auth()->check()) {
        if (!auth()->user()->isPelanggan()) {
            return redirect()->route('dashboard');
        }
    }

    return view('home');
})->name('home');

// Autentikasi Tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
});

// Katalog Produk & Kategori Publik
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

// Area Terproteksi Login
Route::middleware('auth')->group(function () {
    // Logout & Profil
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');

    // Dashboard Finansial & Operasional (Hanya Pemilik & Kasir)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:pemilik,kasir')
        ->name('dashboard');

    // Transaksi Kasir (Pemilik & Kasir)
    Route::middleware('role:pemilik,kasir')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/baru', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/transaksi/{transaksi}/cetak', [TransaksiController::class, 'printReceipt'])->name('transaksi.print');
    });

    // Khusus Hak Akses Pemilik
    Route::middleware('role:pemilik')->group(function () {
        // Kelola Produk
        Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // Kelola Kategori
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Laporan Keuangan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // Kelola Pesanan dari Pelanggan
        Route::get('/pesanan/kelola', [PesananController::class, 'kelolaIndex'])->name('pesanan.kelola');
        Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    });

    // Pesanan Pelanggan (keranjang & checkout)
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
        Route::post('/keranjang/{produk}', [PesananController::class, 'tambahKeranjang'])->name('pesanan.tambah-keranjang');
        Route::patch('/keranjang/{key}', [PesananController::class, 'updateKeranjang'])->name('pesanan.update-keranjang');
        Route::delete('/keranjang/{key}', [PesananController::class, 'hapusKeranjang'])->name('pesanan.hapus-keranjang');
        Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
        Route::post('/checkout', [PesananController::class, 'prosesPesanan'])->name('pesanan.proses');
        Route::get('/pesanan', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
        Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::patch('/pesanan/{pesanan}/batal', [PesananController::class, 'batal'])->name('pesanan.batal');
    });
});
