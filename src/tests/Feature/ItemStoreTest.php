<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品出品画面にて必要な情報が保存できること()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $categoryA = Category::create(['content' => 'カテゴリーA']);
        $categoryB = Category::create(['content' => 'カテゴリーB']);

        $this->get(route('sell.create'))
            ->assertStatus(200);

        $data = [
            'img_path' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            'category_id' => [$categoryA->id, $categoryB->id],
            'condition' => 1,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文',
            'price' => 5000,
        ];

        $response = $this->post(route('sell.store'), $data);

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文',
            'price' => 5000,
            'condition' => 1,
            'user_id' => $user->id,
        ]);

        $item = Item::first();
        Storage::disk('public')->assertExists($item->img_path);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categoryA->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categoryB->id,
        ]);
    }
}
