<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->name(),
            'title' => $this->faker->name() . $this->faker->name(),
            'description' => $this->faker->text(),
            'organizer' => $this->faker->firstName(),
            'location' => $this->faker->streetAddress(),
            'geo' => '{"long": "0.30", "lat": "6.0"}',
            'schedule' => $this->faker->date(),
            'amount' => $this->faker->numberBetween(10000, 500000),
            'supply' => $this->faker->numberBetween(1000, 5000),
            'start' => now(),
            'end' => Carbon::tomorrow(),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
