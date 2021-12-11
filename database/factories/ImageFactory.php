<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'https://img.freepik.com/free-vector/theater-stage-with-red-open-curtain-red-seats-with-people-comedy-tragedy-theatre-masks-vector-template-illustration_273525-123.jpg?size=626&ext=jpg',
            'caption' => $this->faker->text(),
            'user_id' => $this->faker->numberBetween(1, 10),
            'imageable_id' => $this->faker->numberBetween(1, 100),
            'imageable_type' => 'ticket'
        ];
    }
}
