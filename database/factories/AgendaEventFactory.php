<?php

namespace Database\Factories;

use App\Models\AgendaEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AgendaEvent>
 */
class AgendaEventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'start_dateTime'  => $this->faker->date(),
            'end_dateTime'    => $this->faker->date(),
            'place'       => $this->faker->city(),
            'location'    => $this->faker->address(),
            'description' => $this->faker->paragraph(3),
            'cancelled'   => $this->faker->boolean(20), // 20% chance of being cancelled
        ];
    }
}
