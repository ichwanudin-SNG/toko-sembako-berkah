<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganPemesananTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelanggan_can_add_a_product_to_the_cart_from_the_catalog(): void
    {
        $pelanggan = User::create([
            'username' => 'pelanggan-test',
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@example.com',
            'password' => 'password',
            'role' => 'pelanggan',
        ]);
        $kategori = Kategori::create(['nama_kategori' => 'Sembako']);
        $produk = Produk::create([
            'kode_produk' => 'BRG-TEST',
            'nama_produk' => 'Beras Test',
            'kategori_id' => $kategori->id,
            'stok' => 10,
            'harga_beli' => 10000,
            'harga_jual' => 12000,
            'satuan' => 'kg',
        ]);

        $this->actingAs($pelanggan)
            ->get(route('produk.index'))
            ->assertOk()
            ->assertSee(route('pesanan.tambah-keranjang', $produk), false)
            ->assertSee('Tambah');

        $this->post(route('pesanan.tambah-keranjang', $produk), ['jumlah' => 2])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(2, session('keranjang')['produk_' . $produk->id]['jumlah']);
    }
}
