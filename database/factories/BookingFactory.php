<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(7, 18);

        return [
            'req_id'        => 'REQ-' . fake()->unique()->numerify('########'),
            'user_id'       => User::factory(),
            'room_id'       => Room::factory(),
            'date'          => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'start_time'    => str_pad($startHour, 2, '0', STR_PAD_LEFT) . ':00:00',
            'end_time'      => str_pad($startHour + 2, 2, '0', STR_PAD_LEFT) . ':00:00',
            'activity_name' => fake()->sentence(3),
            'activity_type' => fake()->randomElement(['Sidang', 'Ormawa', 'Fakultas']),
            'participants'  => fake()->numberBetween(10, 50),
            'document_path' => null,
            'purpose'       => fake()->paragraph(),
            'status'        => 'menunggu',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'           => 'ditolak',
            'rejection_reason' => fake()->sentence(),
        ]);
    }
}
