<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'data' => [
                    'name'=> '腕時計',
                    'brand' => 'Rolex',
                    'price' => 15000,
                    'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                    'condition_id' => 1,
                    'seller_id' => 1,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                ],
                'categories' => [1, 5, 12],
            ],
            [
                'data' => [
                    'name'=> 'HDD',
                    'brand' => '西芝',
                    'price' => 5000,
                    'detail' => '高速で信頼性の高いハードディスク',
                    'condition_id' => 2,
                    'seller_id' => 2,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                ],
                'categories' => [2],
            ],
            [
                'data' => [
                    'name'=> '玉ねぎ3束',
                    'brand' => 'なし',
                    'price' => 300,
                    'detail' => '新鮮な玉ねぎ3束のセット',
                    'condition_id' => 3,
                    'seller_id' => 3,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                ],
                'categories' => [10],
            ],
            [
                'data' => [
                    'name'=> '革靴',
                    'brand' => '',
                    'price' => 4000,
                    'detail' => 'クラシックなデザインの革靴',
                    'condition_id' => 4,
                    'seller_id' => 4,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                ],
                'categories' => [1, 5],
            ],
            [
                'data' => [
                    'name'=> 'ノートPC',
                    'brand' => '',
                    'price' => 45000,
                    'detail' => '高性能なノートパソコン',
                    'condition_id' => 1,
                    'seller_id' => 5,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                ],
                'categories' => [2],
            ],
            [
                'data' => [
                    'name'=> 'マイク',
                    'brand' => 'なし',
                    'price' => 8000,
                    'detail' => '高音質のレコーディング用マイク',
                    'condition_id' => 2,
                    'seller_id' => 1,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                ],
                'categories' => [2, 8, 13],
            ],
            [
                'data' => [
                    'name'=> 'ショルダーバッグ',
                    'brand' => '',
                    'price' => 3500,
                    'detail' => 'おしゃれなショルダーバッグ',
                    'condition_id' => 3,
                    'seller_id' => 2,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                ],
                'categories' => [1, 4, 5],
            ],
            [
                'data' => [
                    'name'=> 'タンブラー',
                    'brand' => 'なし',
                    'price' => 500,
                    'detail' => '使いやすいタンブラー',
                    'condition_id' => 4,
                    'seller_id' => 3,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                ],
                'categories' => [10],
            ],
            [
                'data' => [
                    'name'=> 'コーヒーミル',
                    'brand' => 'Starbacks',
                    'price' => 4000,
                    'detail' => '手動のコーヒーミル',
                    'condition_id' => 1,
                    'seller_id' => 4,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                ],
                'categories' => [10],
            ],
            [
                'data' => [
                    'name'=> 'メイクセット',
                    'brand' => '',
                    'price' => 2500,
                    'detail' => '便利なメイクアップセット',
                    'condition_id' => 2,
                    'seller_id' => 5,
                    'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                ],
                'categories' => [1, 4, 6],
            ],
        ];

        foreach ($items as $item) {
            $createdItem = Item::create($item['data']);
            $createdItem->categories()->attach($item['categories']);
        }
    }
}
