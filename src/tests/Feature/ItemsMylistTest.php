<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class ItemsMylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $user->likedItems()->attach($item->id);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist');
        $response->assertSee($item->name);
    }

    public function test_購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'is_sold' => 1,
        ]);

        $user->likedItems()->attach($item->id);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/?tab=mylist');
        $response->assertSee($item->name);
        $response->assertSee('Sold');
    }

    public function test_未認証の場合は何も表示されない()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertViewHas('items', fn($items) => $items->isEmpty());
    }
}
