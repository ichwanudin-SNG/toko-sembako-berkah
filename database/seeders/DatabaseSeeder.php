<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Pemilik & Kasir)
        $pemilik = User::create([
            'username' => 'pemilik',
            'name' => 'Haji Berkah (Pemilik Toko)',
            'email' => 'pemilik@sembako.com',
            'password' => Hash::make('password123'),
            'role' => 'pemilik',
        ]);

        $kasir = User::create([
            'username' => 'kasir',
            'name' => 'Siti Kasir',
            'email' => 'kasir@sembako.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        // 2. Seed Kategori Sembako
        $katBeras = Kategori::create([
            'nama_kategori' => 'Beras & Biji-bijian',
            'keterangan' => 'Aneka beras premium, ketan, dan kacang-kacangan'
        ]);

        $katMinyak = Kategori::create([
            'nama_kategori' => 'Minyak Goreng & Margarin',
            'keterangan' => 'Minyak sawit kemasan dan mentega masak'
        ]);

        $katGula = Kategori::create([
            'nama_kategori' => 'Gula & Pemanis',
            'keterangan' => 'Gula pasir kristal, gula merah, pemanis'
        ]);

        $katTepung = Kategori::create([
            'nama_kategori' => 'Telur & Tepung',
            'keterangan' => 'Telur ayam negeri, tepung terigu, beras, tapioka'
        ]);

        $katInstan = Kategori::create([
            'nama_kategori' => 'Makanan Instan & Kaleng',
            'keterangan' => 'Mie instan, sarden, kornet'
        ]);

        $katMinuman = Kategori::create([
            'nama_kategori' => 'Minuman, Kopi & Teh',
            'keterangan' => 'Kopi sachet, teh celup, susu kental manis'
        ]);

        $katBumbu = Kategori::create([
            'nama_kategori' => 'Bumbu Dapur',
            'keterangan' => 'Penyedap rasa, kecap, saus, garam'
        ]);

        // 3. Seed Produk Sembako dengan Gambar
        $p1 = Produk::create([
            'kode_produk' => 'BRG-001',
            'nama_produk' => 'Beras Rojo Lele 5kg',
            'kategori_id' => $katBeras->id,
            'stok' => 45,
            'harga_beli' => 62000,
            'harga_jual' => 68000,
            'satuan' => 'karung',
            'gambar' => 'images/produk/beras.svg',
        ]);

        $p2 = Produk::create([
            'kode_produk' => 'BRG-002',
            'nama_produk' => 'Beras Pandan Wangi 5kg',
            'kategori_id' => $katBeras->id,
            'stok' => 30,
            'harga_beli' => 68000,
            'harga_jual' => 75000,
            'satuan' => 'karung',
            'gambar' => 'images/produk/beras.svg',
        ]);

        $p3 = Produk::create([
            'kode_produk' => 'BRG-003',
            'nama_produk' => 'Minyak Goreng Bimoli 2 Liter',
            'kategori_id' => $katMinyak->id,
            'stok' => 50,
            'harga_beli' => 32000,
            'harga_jual' => 36000,
            'satuan' => 'pouch',
            'gambar' => 'images/produk/minyak.svg',
        ]);

        $p4 = Produk::create([
            'kode_produk' => 'BRG-004',
            'nama_produk' => 'Minyak Goreng Tropical 2 Liter',
            'kategori_id' => $katMinyak->id,
            'stok' => 35,
            'harga_beli' => 33000,
            'harga_jual' => 37500,
            'satuan' => 'pouch',
            'gambar' => 'images/produk/minyak.svg',
        ]);

        $p5 = Produk::create([
            'kode_produk' => 'BRG-005',
            'nama_produk' => 'Gula Pasir Gulaku Premium 1kg',
            'kategori_id' => $katGula->id,
            'stok' => 60,
            'harga_beli' => 15500,
            'harga_jual' => 17500,
            'satuan' => 'kg',
            'gambar' => 'images/produk/gula.svg',
        ]);

        $p6 = Produk::create([
            'kode_produk' => 'BRG-006',
            'nama_produk' => 'Telur Ayam Negeri Segar 1kg',
            'kategori_id' => $katTepung->id,
            'stok' => 25,
            'harga_beli' => 26000,
            'harga_jual' => 29000,
            'satuan' => 'kg',
            'gambar' => 'images/produk/telur.svg',
        ]);

        $p7 = Produk::create([
            'kode_produk' => 'BRG-007',
            'nama_produk' => 'Tepung Terigu Segitiga Biru 1kg',
            'kategori_id' => $katTepung->id,
            'stok' => 40,
            'harga_beli' => 11000,
            'harga_jual' => 13000,
            'satuan' => 'kg',
            'gambar' => 'images/produk/tepung.svg',
        ]);

        $p8 = Produk::create([
            'kode_produk' => 'BRG-008',
            'nama_produk' => 'Indomie Goreng Spesial 85g',
            'kategori_id' => $katInstan->id,
            'stok' => 120,
            'harga_beli' => 2800,
            'harga_jual' => 3500,
            'satuan' => 'bungkus',
            'gambar' => 'images/produk/mie.svg',
        ]);

        $p9 = Produk::create([
            'kode_produk' => 'BRG-009',
            'nama_produk' => 'Kopi Kapal Api Spesial 165g',
            'kategori_id' => $katMinuman->id,
            'stok' => 40,
            'harga_beli' => 12500,
            'harga_jual' => 15000,
            'satuan' => 'bungkus',
            'gambar' => 'images/produk/kopi.svg',
        ]);

        $p10 = Produk::create([
            'kode_produk' => 'BRG-010',
            'nama_produk' => 'Royco Bumbu Kaldu Ayam 230g',
            'kategori_id' => $katBumbu->id,
            'stok' => 4, // Stok menipis (<5) untuk demo notifikasi
            'harga_beli' => 9000,
            'harga_jual' => 11000,
            'satuan' => 'bungkus',
            'gambar' => 'images/produk/bumbu.svg',
        ]);

        // 4. Seed Contoh Transaksi Pertama
        $trx = Transaksi::create([
            'no_transaksi' => 'TRX-' . date('Ymd') . '-0001',
            'user_id' => $kasir->id,
            'nama_pembeli' => 'Ibu Rahma',
            'total_harga' => 121500,
            'bayar' => 150000,
            'kembalian' => 28500,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $trx->id,
            'produk_id' => $p1->id,
            'jumlah' => 1,
            'harga_saat_jual' => 68000,
            'subtotal' => 68000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $trx->id,
            'produk_id' => $p3->id,
            'jumlah' => 1,
            'harga_saat_jual' => 36000,
            'subtotal' => 36000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $trx->id,
            'produk_id' => $p5->id,
            'jumlah' => 1,
            'harga_saat_jual' => 17500,
            'subtotal' => 17500,
        ]);
    }
}
