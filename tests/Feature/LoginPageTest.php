<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_no_demo_credentials_and_keeps_username_login(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk ke Sistem')
            ->assertSee('name="username"', false)
            ->assertSee('name="password"', false)
            ->assertDontSee('Demo Akun Cepat')
            ->assertDontSee('password123');
    }

    public function test_user_can_sign_in_with_username_and_password(): void
    {
        $user = User::create([
            'username' => 'pelanggan-login-test',
            'name' => 'Pelanggan Login Test',
            'email' => 'pelanggan-login-test@example.com',
            'password' => 'password123',
            'role' => 'pelanggan',
        ]);

        $this->post(route('login.post'), [
            'username' => $user->username,
            'password' => 'password123',
        ])->assertRedirect(route('produk.index'));

        $this->assertAuthenticatedAs($user);
    }
}
