@extends('layouts.app')

@section('title', 'Master Kategori — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Kategori Sembako</span>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <!-- Tabel Kategori -->
    <div class="tabel-kartu">
        <table class="tabel-berkah">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th style="text-align: center;">Jumlah Produk</th>
                    @auth
                        @if(auth()->user()->isPemilik())
                            <th style="text-align: center; width: 140px;">Aksi</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kat)
                    <tr>
                        <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                        <td><strong>{{ $kat->nama_kategori }}</strong></td>
                        <td style="color: #6b7280; font-size: 0.9rem;">{{ $kat->keterangan ?: '-' }}</td>
                        <td style="text-align: center;">
                            <span class="badge badge-info">{{ $kat->produks_count }} Produk</span>
                        </td>
                        @auth
                            @if(auth()->user()->isPemilik())
                                <td style="text-align: center;">
                                    <button class="btn btn-warning btn-sm" onclick="editKategori({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}', '{{ addslashes($kat->keterangan) }}')">Edit</button>
                                    
                                    <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Form Tambah / Edit Kategori (Khusus Pemilik) -->
    @auth
        @if(auth()->user()->isPemilik())
            <div class="tabel-kartu" style="padding: 1.5rem;" id="form-container">
                <h3 id="form-title" style="color: var(--hijau-utama); margin-bottom: 1rem;">+ Tambah Kategori</h3>
                
                <form id="kategori-form" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div id="method-field"></div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Nama Kategori *</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="input-teks" placeholder="Contoh: Bumbu Dapur" required>
                    </div>

                    <div style="margin-bottom: 1.2rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="input-teks" rows="3" placeholder="Deskripsi jenis barang..."></textarea>
                    </div>

                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" id="btn-submit" class="btn btn-primary" style="flex: 1;">Simpan</button>
                        <button type="button" id="btn-batal" class="btn btn-secondary" style="display: none;" onclick="resetForm()">Batal</button>
                    </div>
                </form>
            </div>
        @else
            <div class="tabel-kartu" style="padding: 1.5rem; text-align: center; color: #6b7280;">
                <p>ℹ️ Hanya akun dengan peran <strong>Pemilik</strong> yang dapat menambah atau mengubah kategori.</p>
            </div>
        @endif
    @else
        <div class="tabel-kartu" style="padding: 1.5rem; text-align: center; color: #6b7280;">
            <p>Silakan <a href="{{ route('login') }}" style="color: var(--hijau-utama); font-weight: 600;">login</a> untuk mengelola kategori.</p>
        </div>
    @endauth
</div>

@push('scripts')
<script>
    function editKategori(id, nama, keterangan) {
        document.getElementById('form-title').innerText = '✏️ Edit Kategori';
        const form = document.getElementById('kategori-form');
        form.action = '/kategori/' + id;
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('nama_kategori').value = nama;
        document.getElementById('keterangan').value = keterangan || '';
        document.getElementById('btn-submit').innerText = 'Perbarui';
        document.getElementById('btn-batal').style.display = 'inline-block';
        document.getElementById('nama_kategori').focus();
    }

    function resetForm() {
        document.getElementById('form-title').innerText = '+ Tambah Kategori';
        const form = document.getElementById('kategori-form');
        form.action = "{{ route('kategori.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('nama_kategori').value = '';
        document.getElementById('keterangan').value = '';
        document.getElementById('btn-submit').innerText = 'Simpan';
        document.getElementById('btn-batal').style.display = 'none';
    }
</script>
@endpush
@endsection

