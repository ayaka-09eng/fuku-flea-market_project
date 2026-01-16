<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 10000),
            'brand' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'condition' => $this->faker->randomElement([0, 1, 2, 3]),
            'img_path' => 'images/sample.png',
            'is_sold' => $this->faker->boolean(),
        ];
    }
}
