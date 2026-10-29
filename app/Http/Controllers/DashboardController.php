<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Metrik Produk & Inventaris
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        
        // Total Nilai Modal Inventaris (Pengeluaran Stok)
        $totalModalInventaris = Produk::select(DB::raw('SUM(stok * harga_beli) as total_modal'))->value('total_modal') ?? 0;
        
        // Total Nilai Jual Potensial
        $totalPotensiOmset = Produk::select(DB::raw('SUM(stok * harga_jual) as total_jual'))->value('total_jual') ?? 0;

        // 2. Metrik Transaksi Hari Ini
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();
        $omsetHariIni = Transaksi::whereDate('created_at', $today)->sum('total_harga');

        // 3. Metrik Transaksi Total (Penghasilan Akumulatif)
        $totalTransaksi = Transaksi::count();
        $totalOmset = Transaksi::sum('total_harga');

        // Estimasi Keuntungan / Profit (Penjualan - Modal Terjual)
        $detailTerjual = DetailTransaksi::join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->select(
                DB::raw('SUM(detail_transaksis.subtotal) as total_penjualan'),
                DB::raw('SUM(detail_transaksis.jumlah * produks.harga_beli) as total_modal_terjual')
            )->first();

        $keuntunganKotor = ($detailTerjual->total_penjualan ?? 0) - ($detailTerjual->total_modal_terjual ?? 0);

        // 4. Produk Stok Menipis (<= 5)
        $stokMenipis = Produk::with('kategori')->where('stok', '<=', 5)->get();

        // 5. 5 Transaksi Terakhir
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'totalModalInventaris',
            'totalPotensiOmset',
            'transaksiHariIni',
            'omsetHariIni',
            'totalTransaksi',
            'totalOmset',
            'keuntunganKotor',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }
}

