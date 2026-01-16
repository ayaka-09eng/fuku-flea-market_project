<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\UserProfile;

class PurchasePaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_小計画面で変更が反映される()
    {
        $user = User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->create();

        $profile = $user->profile;

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.create', $item->id))
            ->assertStatus(200);

        $response->assertSee('カード支払い');
        $response->assertSee('コンビニ払い');

        $selectedPaymentMethod = 1;

        $this->post(route('purchase.store', $item->id), [
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
            'payment_method' => $selectedPaymentMethod,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 1,
        ]);
    }
}
