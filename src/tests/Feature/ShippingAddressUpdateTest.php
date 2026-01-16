<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\UserProfile;

class ShippingAddressUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        $user = User::factory()
        ->has(UserProfile::factory(), 'profile')
        ->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $newAddress = [
            'postal_code' => '999-9999',
            'address' => '東京都テスト区サンプル1-2-3',
            'building' => 'テストマンション101',
        ];

        $response = $this->post(route('purchase.address.update', $item->id), $newAddress);

        $response->assertRedirect(route('purchase.create', $item->id));

        $response = $this->followRedirects($response);
        $response->assertStatus(200);

        $response->assertSee('999-9999');
        $response->assertSee('東京都テスト区サンプル1-2-3');
        $response->assertSee('テストマンション101');
    }

    public function test_購入した商品に送付先住所が紐づいて登録される()
    {
        $user = User::factory()
        ->has(UserProfile::factory(), 'profile')
        ->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $newAddress = [
            'postal_code' => '999-9999',
            'address' => '東京都テスト区サンプル1-2-3',
            'building' => 'テストマンション101',
        ];

        $response = $this->post(route('purchase.address.update', $item->id), $newAddress);

        $response->assertRedirect(route('purchase.create', $item->id));

        $response = $this->followRedirects($response);
        $response->assertSee('999-9999');

        $response = $this->post(route('purchase.store', $item->id), [
            'postal_code' => $newAddress['postal_code'],
            'address' => $newAddress['address'],
            'building' => $newAddress['building'],
            'payment_method' => 0,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '999-9999',
            'address' => '東京都テスト区サンプル1-2-3',
            'building' => 'テストマンション101',
        ]);
    }
}
