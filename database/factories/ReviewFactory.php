<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(),
            'user_id' => $this->faker->numberBetween(1, 10),
            'reviewable_id' => $this->faker->numberBetween(1, 100),
            'reviewable_type' => 'ticket'
        ];
    }
}
