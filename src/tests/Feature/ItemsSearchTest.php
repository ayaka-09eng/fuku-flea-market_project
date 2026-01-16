<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class ItemsSearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_「商品名」で部分一致検索ができる()
    {
        $itemHit = Item::factory()->create([
            'name' => 'Apple Watch',
        ]);

        $itemNotHit = Item::factory()->create([
            'name' => 'Samsung Galaxy',
        ]);

        $response = $this->get('/?keyword=App');

        $response->assertSee($itemHit->name);
        $response->assertDontSee($itemNotHit->name);
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $response = $this->get('/?keyword=Apple');

        $response = $this->get('/?tab=mylist&keyword=Apple');

        $response->assertSee('value="Apple"', false);
    }
}
