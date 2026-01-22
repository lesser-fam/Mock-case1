<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        $seller1 = User::factory()->create();
        $seller2 = User::factory()->create();
        
        $item1 = Item::factory()->create([
            'seller_id' => $seller1->id,
            'name' => 'A商品',
        ]);

        $item2 = Item::factory()->create([
            'seller_id' => $seller2->id,
            'name' => 'B商品',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('A商品');
        $response->assertSee('B商品');
    }

    /** @test */
    public function 購入済み商品は「Sold」と表示される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        
        $soldItem = Item::factory()->create([
            'seller_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        $normalItem = Item::factory()->create([
            'seller_id' => $seller->id,
            'name' => '未購入商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $soldItem->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);

        $response = $this->get('/');

        $response->assertSee('購入済み商品');
        $response->assertSee('SOLD');
        $response->assertSee('未購入商品');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        Item::factory()->create([
            'seller_id' => $user->id,
            'name' => '自分の商品',
        ]);

        Item::factory()->create([
            'seller_id' => $otherUser->id,
            'name' => '他人の商品',
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}