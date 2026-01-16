<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use Database\Seeders\CategoriesTableSeeder;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が表示される()
    {
        $this->seed(CategoriesTableSeeder::class);

        $category = Category::first();

        $item = Item::factory()->create([
            'name' => 'Air Max',
            'brand' => 'Nike',
            'price' => 12000,
            'description' => '人気のスニーカーです。',
            'condition' => 1,
            'img_path' => 'https://example.com/image.jpg',
        ]);

        $item->categories()->attach($category->id);

        $user = User::factory()->create(['name' => 'Sanae']);
        Comment::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'body' => 'とても良い商品でした！',
        ]);

        Like::create(['item_id' => $item->id, 'user_id' => $user->id]);
        Like::create(['item_id' => $item->id, 'user_id' => User::factory()->create()->id]);
        Like::create(['item_id' => $item->id, 'user_id' => User::factory()->create()->id]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertSee('Air Max');
        $response->assertSee('Nike');
        $response->assertSee(number_format($item->price));
        $response->assertSee('人気のスニーカーです。');

        $response->assertSee($category->content);
        $response->assertSee(Item::conditions()[$item->condition]);

        $response->assertSee('3');

        $response->assertSee('Sanae');
        $response->assertSee('とても良い商品でした！');

        $response->assertSee('https://example.com/image.jpg');
    }

    public function test_複数選択されたカテゴリが表示されているか()
    {
        $this->seed(CategoriesTableSeeder::class);

        $categories = Category::take(2)->get();

        $item = Item::factory()->create([
            'name' => 'Air Max',
            'brand' => 'Nike',
            'price' => 12000,
            'description' => '人気のスニーカーです。',
            'condition' => 1,
            'img_path' => 'https://example.com/image.jpg',
        ]);

        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get(route('items.show', $item->id));

        foreach ($categories as $category) {
            $response->assertSee($category->content);
        }
    }
}
