<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk_{{ $transaksi->no_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .header h3 {
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        .info {
            margin-bottom: 8px;
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        td {
            padding: 3px 0;
            vertical-align: top;
        }
        .total-box {
            border-top: 1px dashed #000;
            padding-top: 6px;
            margin-top: 6px;
        }
        .footer {
            text-align: center;
            margin-top: 12px;
            border-top: 1px dashed #000;
            padding-top: 8px;
            font-size: 10px;
        }
        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3>TOKO SEMBAKO BERKAH</h3>
        <div>Pasar Induk No. 12</div>
        <div>Telp: 0812-3456-7890</div>
    </div>

    <div class="info">
        <div>No: {{ $transaksi->no_transaksi }}</div>
        <div>Tgl: {{ $transaksi->created_at->format('d/m/y H:i') }}</div>
        <div>Kasir: {{ $transaksi->user->name ?? 'Kasir' }}</div>
        <div>Pelanggan: {{ $transaksi->nama_pembeli ?: 'Umum' }}</div>
    </div>

    <table>
        @foreach($transaksi->detailTransaksis as $d)
            <tr>
                <td colspan="3"><strong>{{ $d->produk->nama_produk ?? 'Barang' }}</strong></td>
            </tr>
            <tr>
                <td style="width: 45%;">{{ $d->jumlah }} x {{ number_format($d->harga_saat_jual, 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="total-box">
        <div style="display: flex; justify-content: space-between; font-weight: bold;">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>BAYAR:</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>KEMBALI:</span>
            <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <div>Terima kasih atas kunjungan Anda!</div>
        <div>Barang yang dibeli tidak dapat ditukar</div>
    </div>

</body>
</html>

