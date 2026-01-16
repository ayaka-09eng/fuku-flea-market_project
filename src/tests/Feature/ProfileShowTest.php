<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Item;
use App\Models\Order;

class ProfileShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が取得できる()
    {
        $user = User::factory()
            ->has(UserProfile::factory([
                'img_path' => 'avatars/test.png',
            ]), 'profile')
            ->create([
                'name' => 'テストユーザー',
            ]);

        $sellingItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
            'img_path' => 'items/a.png',
        ]);

        $purchasedItem = Item::factory()->create([
            'name' => '購入商品B',
            'img_path' => 'items/b.png',
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage')->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('mypage__avatar-img', false);

        $response->assertSee('出品商品A');

        $response = $this->get('/mypage?page=buy')
            ->assertStatus(200);

        $response->assertSee('購入商品B');
    }
}
