<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        $item1 = Item::create([
            'user_id' => $users->random()->id,
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => 0,
            'img_path' => 'items/Armani+Mens+Clock.jpg',
            'is_sold' => 0,
        ]);
        $item1->categories()->attach([5, 12]);

        $item2 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'condition' => 1,
            'img_path' => 'items/HDD+Hard+Disk.jpg',
            'is_sold' => 0,
        ]);
        $item2->categories()->attach(2);

        $item3 = Item::create([
            'user_id' => $users->random()->id,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition' => 2,
            'img_path' => 'items/iLoveIMG+d.jpg',
            'is_sold' => 0,
        ]);
        $item3->categories()->attach(10);

        $item4 = Item::create([
            'user_id' => $users->random()->id,
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'condition' => 3,
            'img_path' => 'items/Leather+Shoes+Product+Photo.jpg',
            'is_sold' => 0,
        ]);
        $item4->categories()->attach(1);

        $item5 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'condition' => 0,
            'img_path' => 'items/Living+Room+Laptop.jpg',
            'is_sold' => 0,
        ]);
        $item5->categories()->attach(2);

        $item6 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'condition' => 1,
            'img_path' => 'items/Music+Mic+4632231.jpg',
            'is_sold' => 0,
        ]);
        $item6->categories()->attach(2);

        $item7 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'condition' => 2,
            'img_path' => 'items/Purse+fashion+pocket.jpg',
            'is_sold' => 0,
        ]);
        $item7->categories()->attach([1, 11]);

        $item8 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'condition' => 3,
            'img_path' => 'items/Tumbler+souvenir.jpg',
            'is_sold' => 0,
        ]);
        $item8->categories()->attach(10);

        $item9 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'condition' => 0,
            'img_path' => 'items/Waitress+with+Coffee+Grinder.jpg',
            'is_sold' => 0,
        ]);
        $item9->categories()->attach(10);

        $item10 = Item::create([
            'user_id' => $users->random()->id,
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'condition' => 1,
            'img_path' => 'items/外出メイクアップセット.jpg',
            'is_sold' => 0,
        ]);
        $item10->categories()->attach(6);
    }
}
