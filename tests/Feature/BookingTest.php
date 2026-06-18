<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_ajukan_page(): void
    {
        $response = $this->get('/user/ajukan');
        $response->assertRedirect('/login');
    }

    public function test_user_can_access_ajukan_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/user/ajukan');

        $response->assertStatus(200);
    }

    public function test_user_can_access_riwayat_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/user/riwayat');

        $response->assertStatus(200);
    }

    public function test_user_can_see_their_own_bookings_only(): void
    {
        $user  = User::factory()->create();
        $other = User::factory()->create();
        $room  = Room::factory()->create();

        Booking::factory()->create(['user_id' => $user->id,  'room_id' => $room->id]);
        Booking::factory()->create(['user_id' => $other->id, 'room_id' => $room->id]);

        $response = $this->actingAs($user)->get('/user/riwayat');

        $response->assertStatus(200);
        $this->assertEquals(1, Booking::where('user_id', $user->id)->count());
    }

    public function test_user_cannot_view_other_users_booking_detail(): void
    {
        $user  = User::factory()->create();
        $other = User::factory()->create();
        $room  = Room::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $other->id,
            'room_id' => $room->id,
        ]);

        $response = $this->actingAs($user)->get("/user/riwayat-detail/{$booking->id}");

        $response->assertStatus(404);
    }

    public function test_booking_is_saved_to_database(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $this->actingAs($user)->post('/user/ajukan-proses', [
            'room_id'       => $room->id,
            'date'          => now()->addDays(3)->format('Y-m-d'),
            'start_time'    => '09:00:00',
            'end_time'      => '11:00:00',
            'activity_name' => 'Rapat Ormawa',
            'activity_type' => 'Ormawa',
            'participants'  => 30,
            'document_path' => 'documents/test.pdf',
            'purpose'       => 'Rapat koordinasi bulanan',
        ]);

        $this->assertDatabaseHas('bookings', [
            'user_id'       => $user->id,
            'room_id'       => $room->id,
            'activity_name' => 'Rapat Ormawa',
            'status'        => 'menunggu',
        ]);
    }

    public function test_booking_status_defaults_to_menunggu(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
        ]);

        $this->assertEquals('menunggu', $booking->status);
    }
}
