<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_the_store_landing_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Kebutuhan harian,')
            ->assertSee('Jelajahi Produk')
            ->assertSee(route('produk.index'), false)
            ->assertSee('Toko Sembako Berkah');
    }

    public function test_customer_can_open_the_landing_page(): void
    {
        $customer = User::create([
            'username' => 'pelanggan-home-test',
            'name' => 'Pelanggan Home Test',
            'email' => 'pelanggan-home-test@example.com',
            'password' => 'password123',
            'role' => 'pelanggan',
        ]);

        $this->actingAs($customer)
            ->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder([
                'Beranda',
                'Produk',
                'Kategori',
                'Keranjang',
                'Pesanan',
                'Profil',
                'Keluar (pelanggan)',
            ])
            ->assertSee(route('pesanan.keranjang'), false)
            ->assertSee(route('pesanan.riwayat'), false)
            ->assertSee(route('profile'), false)
            ->assertSee(route('logout'), false);
    }

    public function test_owner_still_goes_to_the_dashboard_from_home(): void
    {
        $owner = User::create([
            'username' => 'pemilik-home-test',
            'name' => 'Pemilik Home Test',
            'email' => 'pemilik-home-test@example.com',
            'password' => 'password123',
            'role' => 'pemilik',
        ]);

        $this->actingAs($owner)
            ->get(route('home'))
            ->assertRedirect(route('dashboard'));
    }
}
