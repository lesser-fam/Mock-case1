<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Purchase;

class ItemShowTest extends TestCase
{
     use RefreshDatabase;

    /** @test */
    public function 商品詳細情報が正しく表示される()
    {
        $user = User::factory()->create();

        Profile::factory()->create([
            'user_id' => $user->id,
            'user_name' => 'テストユーザー',
        ]);

        $condition = Condition::factory()->create(['name' => '新品']);

        $item = Item::factory()
            ->for($user, 'seller')
            ->for($condition)
            ->create([
                'name' => 'テスト商品',
                'brand' => 'テストブランド',
                'price' => 5000,
                'detail' => '商品説明テスト',
                'image' => 'test.jpeg'
            ]);

            $category = Category::factory()->create(['name' => '家電']);
            $item->categories()->attach($category);

            Favorite::factory()->create([
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]);

            Favorite::factory()->create([
                'item_id' => $item->id,
                'user_id' => User::factory()->create()->id,
            ]);

            Comment::factory()->create([
                'item_id' => $item->id,
                'user_id' => $user->id,
                'detail' => 'コメント内容',
            ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee($item->image_url);
        $response->assertSee('alt="' . $item->name . '"', false);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥5,000');
        $response->assertSee('(税込)');
        $response->assertSee('商品説明テスト');
        $response->assertSee('家電');
        $response->assertSee('新品');
        $response->assertSee('2');  // いいね数
        $response->assertSee('1');  // コメント数
        $response->assertSee('コメント(1)');   // コメント見出し 
        $response->assertSee('コメント内容');
        $response->assertSee('storage/default.png');
        $response->assertSee('テストユーザー');

    }

    /** @test */
    public function 複数選択されたカテゴリが表示されている()
    {
        $item = Item::factory()->create();

        $categories = Category::factory()->count(3)->create();
        $item->categories()->attach($categories);

        $response = $this->get(route('items.show', $item->id));

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }

    /** @test */
    public function 購入済み商品は「Sold」と表示される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $item = Item::factory()
            ->for($seller, 'seller')
            ->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('SOLD');
        $response->assertSee('売り切れました');
    }
}
