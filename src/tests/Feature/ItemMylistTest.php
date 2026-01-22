<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;

class ItemMylistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create([
            'name' => 'いいね商品'
        ]);

        $notLikedItem = Item::factory()->create([
            'name' => 'いいねしていない商品'
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);
        
        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいね商品');
        $response->assertDontSee('いいねしていない商品');
    }

    /** @test */
    public function 購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();

        $soldItem = Item::factory()->create([
            'name' => '購入済み商品'
        ]);

        $normalItem = Item::factory()->create([
            'name' => '未購入商品'
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $soldItem->id,
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $normalItem->id,
        ]);

        Purchase::factory()->create([
            'item_id' => $soldItem->id,
            'buyer_id' => $user->id,
            'status' => 'paid',
        ]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertSee('購入済み商品');
        $response->assertSee('SOLD');
        $response->assertSee('未購入商品');
    }

    /** @test */
    public function 未認証の場合は何も表示されない()
    {
        Item::factory()->create([
            'name' => '表示されてはいけない商品'
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('表示されてはいけない商品');
    }
}
