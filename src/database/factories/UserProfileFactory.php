<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'postal_code' => $this->faker->numerify('###-####'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->secondaryAddress(),
        ];
    }
}
