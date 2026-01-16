<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;

class ItemsIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_全商品を取得できる()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get(route('items.index'))->assertStatus(200)->assertViewIs('items.index');

        $response->assertViewHas('items', function ($viewItems) use ($items) {
            return $viewItems->count() === $items->count();
        });
    }

    public function test_購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'is_sold' => 1,
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage?page=buy');
        $response->assertSee('Sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $otherItem = Item::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('items.index'));
        $response->assertDontSee($myItem->name);

        $response->assertSee($otherItem->name);
    }
}
