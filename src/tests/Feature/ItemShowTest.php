<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
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
        $condition = Condition::factory()->create(['name' => '新品']);

        $item = Item::factory()
            ->for($user, 'seller')
            ->for($condition)
            ->create([
                'name' => 'テスト商品',
                'brand' => 'テストブランド',
                'price' => 5000,
                'detail' => '商品説明テスト',
            ]);

            $categories = Category::factory()->count(2)->create();
            $item->categories()->attach($categories);

            Favorite::factory()->create([
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]);

            Comment::factory()->create([
                'item_id' => $item->id,
                'user_id' => $user->id,
                'detail' => 'コメント内容',
            ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥5,000');
        $response->assertSee('商品説明テスト');
        $response->assertSee('新品');
        $response->assertSee('1');
        $response->assertSee('コメント(1)');
        $response->assertSee('コメント内容');
        $response->assertSee($user->profile->user_name);
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
