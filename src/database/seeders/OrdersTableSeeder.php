<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        $methods = [0, 1];
        $itemsToPurchase = $items->take(3);

        foreach ($itemsToPurchase as $item) {
            $buyer = User::where('id', '!=', $item->user_id)
                ->inRandomOrder()
                ->first();

            if (!$buyer) {
                continue;
            }

            $profile = $buyer->profile;

            Order::create([
                'item_id' => $item->id,
                'user_id' => $buyer->id,
                'postal_code' => $profile->postal_code,
                'address' => $profile->address,
                'building' => $profile->building,
                'payment_method' => $methods[array_rand($methods)],
            ]);
            $item->update(['is_sold' => 1]);
        }
    }
}
