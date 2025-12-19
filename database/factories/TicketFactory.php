<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull(),
            'title' => $this->faker->word(3, true),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['A', 'C', 'H', 'X']),
        ];
    }
}
