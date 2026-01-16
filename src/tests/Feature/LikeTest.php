<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねアイコンを押下することによって、いいねした商品として登録することができる。()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertStatus(200);

        $response = $this->post(route('items.like', $item->id));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'liked',
                'count' => 1,
            ]);

        $this->assertDatabaseHas('likes', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('items.show', $item->id));
        $response->assertViewHas('item', function ($viewItem) {
            return $viewItem->likes->count() === 1;
        });
        $response->assertSee('1');
    }

    public function test_追加済みのアイコンは色が変化する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertStatus(200);

        $response = $this->post(route('items.like', $item->id));

        $response->assertJson([
            'status' => 'liked',
        ]);

        $this->assertDatabaseHas('likes', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertViewHas('item', function ($viewItem) use ($user) {
            return $viewItem->likes->contains($user->id);
        });
    }

    public function test_再度いいねアイコンを押下することによって、いいねを解除することができる。()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertStatus(200);

        $this->post(route('items.like', $item->id))
            ->assertStatus(200)
            ->assertJson([
                'status' => 'liked',
                'count' => 1,
            ]);

        $this->assertDatabaseHas('likes', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->post(route('items.like', $item->id));
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'unliked',
                'count' => 0,
            ]);

        $this->assertDatabaseMissing('likes', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('items.show', $item->id));
        $response->assertViewHas('item', function ($viewItem) {
            return $viewItem->likes->count() === 0;
        });
        $response->assertSee('0');
    }
}
