<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'building_id' => fake()->randomElement(['A', 'B', 'C']),
            'code'        => 'R-' . fake()->unique()->numerify('###'),
            'name'        => fake()->randomElement([
                'Ruang Seminar',
                'Lab Komputer',
                'Auditorium',
                'Ruang Rapat',
                'Ruang Kelas',
            ]) . ' ' . fake()->numberBetween(1, 10),
            'capacity'    => fake()->randomElement([30, 40, 50, 100, 200]),
            'facilities'  => 'AC, Proyektor, Whiteboard',
            'image_path'  => null,
        ];
    }
}
