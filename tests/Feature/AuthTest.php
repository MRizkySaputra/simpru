<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_page_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('password123'),
            'role'     => 'mahasiswa',
        ]);

        $response = $this->post('/login-process', [
            'username' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_redirected_to_admin_dashboard_after_login(): void
    {
        $admin = User::factory()->admin()->create([
            'email'    => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login-process', [
            'username' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login-process', [
            'username' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register-process', [
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@example.com',
            'id_number'             => '1234567890',
            'role'                  => 'mahasiswa',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/register-success');
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'role'  => 'mahasiswa',
        ]);
    }

    public function test_register_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'budi@example.com']);

        $response = $this->post('/register-process', [
            'name'                  => 'Budi Lain',
            'email'                 => 'budi@example.com',
            'id_number'             => '9999999999',
            'role'                  => 'mahasiswa',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_cannot_access_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}
