<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence(rand(1, 4)),
            'content' => $this->faker->realText(100),
        ];
    }
}
