<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Ambil transaksi dalam rentang tanggal
        $transaksis = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPenghasilan = $transaksis->sum('total_harga');
        $totalTransaksiCount = $transaksis->count();

        // Hitung total modal HPP (Harga Pokok Penjualan) & laba bersih
        $transaksiIds = $transaksis->pluck('id');
        $hppData = DetailTransaksi::join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->whereIn('detail_transaksis.transaksi_id', $transaksiIds)
            ->select(
                DB::raw('SUM(detail_transaksis.jumlah * produks.harga_beli) as total_hpp'),
                DB::raw('SUM(detail_transaksis.subtotal) as total_omset')
            )->first();

        $totalHpp = $hppData->total_hpp ?? 0;
        $labaBersih = ($hppData->total_omset ?? 0) - $totalHpp;

        return view('laporan.index', compact(
            'transaksis',
            'startDate',
            'endDate',
            'totalPenghasilan',
            'totalTransaksiCount',
            'totalHpp',
            'labaBersih'
        ));
    }
}

