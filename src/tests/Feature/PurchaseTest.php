<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\UserProfile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_「購入する」ボタンを押下すると購入が完了する()
    {
        $user = User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->create();

        $profile = $user->profile;

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.create', $item->id))
            ->assertStatus(200);

        $response->assertViewHas('item', function ($viewItem) use ($item) {
            return $viewItem->id === $item->id;
        });

        $response->assertViewHas('paymentMethods');

        $response->assertViewHas('profile', function ($viewProfile) use ($profile) {
            return $viewProfile->id === $profile->id;
        });

        $response = $this->post(route('purchase.store', $item->id), [
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);
    }

    public function test_購入した商品は商品一覧画面にて「sold」と表示される()
    {
        $user = User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->create();

        $profile = $user->profile;

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.create', $item->id));

        $response->assertStatus(200);

        $response->assertViewHas('item', function ($viewItem) use ($item) {
            return $viewItem->id === $item->id;
        });

        $response->assertViewHas('paymentMethods');

        $response->assertViewHas('profile', function ($viewProfile) use ($profile) {
            return $viewProfile->id === $profile->id;
        });

        $response = $this->post(route('purchase.store', $item->id), [
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);

        $response = $this->get(route('items.index'))
            ->assertStatus(200)
            ->assertViewIs('items.index');
        $response->assertSee('Sold');
    }

    public function test_「プロフィール購入した商品一覧」に追加されている()
    {
        $user = User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->create();

        $profile = $user->profile;

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.create', $item->id));

        $response->assertStatus(200);

        $response->assertViewHas('item', function ($viewItem) use ($item) {
            return $viewItem->id === $item->id;
        });

        $response->assertViewHas('paymentMethods');

        $response->assertViewHas('profile', function ($viewProfile) use ($profile) {
            return $viewProfile->id === $profile->id;
        });

        $response = $this->post(route('purchase.store', $item->id), [
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => 0,
        ]);

        $response = $this->get(route('mypage', ['page' => 'buy']))
            ->assertStatus(200)
            ->assertViewIs('users.mypage');
        $response->assertSee($item->name);
    }
}
