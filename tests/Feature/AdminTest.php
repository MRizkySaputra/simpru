<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertRedirect('/user/dashboard');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_permohonan_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/permohonan');

        $response->assertStatus(200);
    }

    public function test_admin_can_approve_booking(): void
    {
        $admin   = User::factory()->admin()->create();
        $user    = User::factory()->create();
        $room    = Room::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'status'  => 'menunggu',
        ]);

        $this->actingAs($admin)->post("/admin/proses-permohonan/{$booking->id}", [
            'action' => 'setujui',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id'     => $booking->id,
            'status' => 'disetujui',
        ]);
    }

    public function test_admin_can_reject_booking_with_reason(): void
    {
        $admin   = User::factory()->admin()->create();
        $user    = User::factory()->create();
        $room    = Room::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'status'  => 'menunggu',
        ]);

        $this->actingAs($admin)->post("/admin/proses-permohonan/{$booking->id}", [
            'action'            => 'tolak',
            'alasan_penolakan'  => 'Jadwal bentrok dengan acara universitas.',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id'               => $booking->id,
            'status'           => 'ditolak',
            'rejection_reason' => 'Jadwal bentrok dengan acara universitas.',
        ]);
    }

    public function test_admin_can_create_room(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/ruangan/store', [
            'name'        => 'Lab Baru',
            'building_id' => 'A',
            'capacity'    => 40,
            'facilities'  => 'AC, Proyektor',
        ]);

        $this->assertDatabaseHas('rooms', [
            'name'     => 'Lab Baru',
            'capacity' => 40,
        ]);
    }

    public function test_admin_can_delete_room(): void
    {
        $admin = User::factory()->admin()->create();
        $room  = Room::factory()->create();

        $this->actingAs($admin)->delete("/admin/ruangan/{$room->id}");

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/users/store', [
            'name'            => 'User Baru',
            'email'           => 'userbaru@example.com',
            'identity_number' => '1122334455',
            'role'            => 'mahasiswa',
            'password'        => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'userbaru@example.com',
            'role'  => 'mahasiswa',
        ]);
    }

    public function test_admin_can_toggle_user_status(): void
    {
        $admin = User::factory()->admin()->create();
        $user  = User::factory()->create(['is_active' => true]);

        $this->actingAs($admin)->put("/admin/users/{$user->id}/toggle-status");

        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_change_user_role(): void
    {
        $admin = User::factory()->admin()->create();
        $user  = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($admin)->put("/admin/users/{$user->id}/role", [
            'role_change' => 'dosen',
        ]);

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'role' => 'dosen',
        ]);
    }
}
