<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use App\Models\Item;

class OrderFactory extends Factory
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
            'item_id' => Item::factory(),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => null,
            'payment_method' => $this->faker->randomElement([0, 1]),
        ];
    }
}
