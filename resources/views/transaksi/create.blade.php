@extends('layouts.app')

@section('title', 'Transaksi Kasir — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>🛒 Kasir Penjualan Sembako</span>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">&larr; Riwayat Transaksi</a>
</div>

<div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 1.5rem; align-items: start;">
    <!-- Bagian Kiri: Katalog Produk Siap Jual -->
    <div class="tabel-kartu" style="padding: 1.5rem;">
        <h3 style="color: var(--hijau-utama); margin-bottom: 1rem;">📦 Pilih Produk Sembako</h3>
        
        <input type="text" id="cari-produk-kasir" class="input-teks" placeholder="Ketik nama atau kode barang..." style="margin-bottom: 1rem;" onkeyup="filterProdukKasir()">

        <div style="max-height: 480px; overflow-y: auto; display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;" id="daftar-item-kasir">
            @foreach($produks as $p)
                <div class="item-kartu-kasir" 
                     data-id="{{ $p->id }}" 
                     data-nama="{{ $p->nama_produk }}" 
                     data-kode="{{ $p->kode_produk }}" 
                     data-harga="{{ $p->harga_jual }}" 
                     data-stok="{{ $p->stok }}" 
                     data-satuan="{{ $p->satuan }}"
                     onclick="tambahItemKeranjang({{ $p->id }}, '{{ addslashes($p->nama_produk) }}', {{ $p->harga_jual }}, {{ $p->stok }}, '{{ $p->satuan }}', '{{ $p->gambar_url }}')"
                     style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 0.8rem; cursor: pointer; transition: all 0.2s; background: #fff; display: flex; gap: 0.8rem; align-items: center;">
                    <img src="{{ $p->gambar_url }}" alt="{{ $p->nama_produk }}" style="width: 48px; height: 48px; object-fit: contain; border-radius: 6px; background: #f9fafb; border: 1px solid #e5e7eb; flex-shrink: 0; padding: 2px;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->nama_produk }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.3rem;">{{ $p->kode_produk }} &bull; {{ $p->kategori->nama_kategori ?? 'Umum' }}</div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 700; color: #15803d; font-size: 0.85rem;">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</span>
                            <span class="badge badge-success" style="font-size: 0.7rem;">Stok: {{ $p->stok }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bagian Kanan: Keranjang Belanja & Pembayaran -->
    <div class="tabel-kartu" style="padding: 1.5rem;">
        <h3 style="color: var(--hijau-utama); margin-bottom: 1rem;">🧾 Keranjang & Pembayaran</h3>

        <form action="{{ route('transaksi.store') }}" method="POST" id="form-checkout" onsubmit="return validasiCheckout()">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem;">Nama Pembeli (Opsional)</label>
                <input type="text" name="nama_pembeli" class="input-teks" placeholder="Pelanggan Umum" value="{{ old('nama_pembeli', 'Pelanggan Umum') }}">
            </div>

            <!-- Tabel Item Keranjang -->
            <div style="max-height: 250px; overflow-y: auto; margin-bottom: 1rem; border: 1px solid #e5e7eb; border-radius: 6px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead style="background: #f3f4f6; position: sticky; top: 0;">
                        <tr>
                            <th style="padding: 0.5rem; text-align: left;">Barang</th>
                            <th style="padding: 0.5rem; text-align: center; width: 80px;">Qty</th>
                            <th style="padding: 0.5rem; text-align: right;">Subtotal</th>
                            <th style="padding: 0.5rem; text-align: center; width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody id="badan-keranjang">
                        <tr id="keranjang-kosong">
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #9ca3af;">
                                Klik produk di sebelah kiri untuk menambah ke keranjang.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Harga -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 1.2rem; font-weight: 700;">
                    <span>Total Tagihan:</span>
                    <span style="color: #15803d;" id="tampilan-total">Rp 0</span>
                </div>
                <input type="hidden" name="total_keseluruhan" id="input-total-hidden" value="0">
            </div>

            <!-- Input Pembayaran Bayar -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem;">Uang Diterima (Rp) *</label>
                <input type="number" name="bayar" id="input-bayar" class="input-teks" placeholder="0" min="0" required oninput="hitungKembalian()">
                
                <!-- Quick Cash Buttons -->
                <div style="display: flex; gap: 0.4rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="setUangPas()">Uang Pas</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="tambahUang(50000)">+50.000</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="tambahUang(100000)">+100.000</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="tambahUang(200000)">+200.000</button>
                </div>
            </div>

            <!-- Kembalian -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 1.2rem; display: flex; justify-content: space-between; font-weight: 600;">
                <span>Kembalian:</span>
                <span id="tampilan-kembalian" style="color: #0f172a;">Rp 0</span>
            </div>

            <button type="submit" id="btn-proses-transaksi" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.8rem; font-size: 1rem;" disabled>
                💳 Proses Pembayaran & Simpan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let keranjang = {};

    function filterProdukKasir() {
        const cari = document.getElementById('cari-produk-kasir').value.toLowerCase();
        const items = document.querySelectorAll('#daftar-item-kasir .item-kartu-kasir');
        items.forEach(el => {
            const nama = el.getAttribute('data-nama').toLowerCase();
            const kode = el.getAttribute('data-kode').toLowerCase();
            if (nama.includes(cari) || kode.includes(cari)) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        });
    }

    function tambahItemKeranjang(id, nama, harga, maxStok, satuan, gambar) {
        if (keranjang[id]) {
            if (keranjang[id].jumlah < maxStok) {
                keranjang[id].jumlah++;
            } else {
                alert('Stok barang hanya tersedia ' + maxStok + ' ' + satuan);
                return;
            }
        } else {
            keranjang[id] = {
                id: id,
                nama: nama,
                harga: harga,
                jumlah: 1,
                maxStok: maxStok,
                satuan: satuan,
                gambar: gambar
            };
        }
        renderKeranjang();
    }

    function ubahQty(id, delta) {
        if (!keranjang[id]) return;
        keranjang[id].jumlah += delta;
        if (keranjang[id].jumlah > keranjang[id].maxStok) {
            alert('Maksimal stok tercapai: ' + keranjang[id].maxStok);
            keranjang[id].jumlah = keranjang[id].maxStok;
        }
        if (keranjang[id].jumlah <= 0) {
            delete keranjang[id];
        }
        renderKeranjang();
    }

    function hapusItem(id) {
        delete keranjang[id];
        renderKeranjang();
    }

    function renderKeranjang() {
        const tbody = document.getElementById('badan-keranjang');
        tbody.innerHTML = '';

        const keys = Object.keys(keranjang);
        if (keys.length === 0) {
            tbody.innerHTML = `
                <tr id="keranjang-kosong">
                    <td colspan="4" style="text-align: center; padding: 2rem; color: #9ca3af;">
                        Klik produk di sebelah kiri untuk menambah ke keranjang.
                    </td>
                </tr>
            `;
            document.getElementById('tampilan-total').innerText = 'Rp 0';
            document.getElementById('input-total-hidden').value = 0;
            document.getElementById('btn-proses-transaksi').disabled = true;
            hitungKembalian();
            return;
        }

        let total = 0;
        let index = 0;

        keys.forEach(id => {
            const item = keranjang[id];
            const subtotal = item.harga * item.jumlah;
            total += subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="padding: 0.6rem 0.5rem; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        <img src="${item.gambar}" style="width: 32px; height: 32px; object-fit: contain; border-radius: 4px; border: 1px solid #e5e7eb; background: #fff; flex-shrink: 0; padding: 1px;">
                        <div>
                            <strong>${item.nama}</strong>
                            <div style="font-size: 0.75rem; color: #6b7280;">Rp ${item.harga.toLocaleString('id-ID')} / ${item.satuan}</div>
                        </div>
                    </div>
                    <input type="hidden" name="items[${index}][produk_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.jumlah}">
                </td>
                <td style="padding: 0.6rem 0.5rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 4px;">
                        <button type="button" onclick="ubahQty(${item.id}, -1)" style="padding: 2px 6px; cursor: pointer; border: 1px solid #ccc; border-radius: 4px;">-</button>
                        <span style="font-weight: 600; min-width: 20px;">${item.jumlah}</span>
                        <button type="button" onclick="ubahQty(${item.id}, 1)" style="padding: 2px 6px; cursor: pointer; border: 1px solid #ccc; border-radius: 4px;">+</button>
                    </div>
                </td>
                <td style="padding: 0.6rem 0.5rem; text-align: right; font-weight: 600; border-bottom: 1px solid #f3f4f6;">
                    Rp ${subtotal.toLocaleString('id-ID')}
                </td>
                <td style="padding: 0.6rem 0.5rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                    <span onclick="hapusItem(${item.id})" style="color: #ef4444; cursor: pointer; font-weight: bold;">&times;</span>
                </td>
            `;
            tbody.appendChild(tr);
            index++;
        });

        document.getElementById('tampilan-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('input-total-hidden').value = total;
        document.getElementById('btn-proses-transaksi').disabled = false;
        hitungKembalian();
    }

    function hitungKembalian() {
        const total = parseFloat(document.getElementById('input-total-hidden').value) || 0;
        const bayar = parseFloat(document.getElementById('input-bayar').value) || 0;
        const kembalian = bayar - total;

        const tampilan = document.getElementById('tampilan-kembalian');
        if (kembalian >= 0) {
            tampilan.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
            tampilan.style.color = '#15803d';
        } else {
            tampilan.innerText = 'Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
            tampilan.style.color = '#dc2626';
        }
    }

    function setUangPas() {
        const total = parseFloat(document.getElementById('input-total-hidden').value) || 0;
        document.getElementById('input-bayar').value = total;
        hitungKembalian();
    }

    function tambahUang(nominal) {
        const input = document.getElementById('input-bayar');
        const curr = parseFloat(input.value) || 0;
        input.value = curr + nominal;
        hitungKembalian();
    }

    function validasiCheckout() {
        const total = parseFloat(document.getElementById('input-total-hidden').value) || 0;
        const bayar = parseFloat(document.getElementById('input-bayar').value) || 0;
        if (total <= 0) {
            alert('Keranjang belanja masih kosong!');
            return false;
        }
        if (bayar < total) {
            alert('Uang pembayaran masih kurang dari total belanja.');
            return false;
        }
        return true;
    }
</script>
@endpush
@endsection

