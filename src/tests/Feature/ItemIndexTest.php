<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        $seller = User::factory()->create();
        
        $item = Item::factory()->create([
            'seller_id' => $seller->id,
            'name' => 'テスト商品',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    /** @test */
    public function 購入済み商品は「Sold」と表示される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        
        $item = Item::factory()->create([
            'seller_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('SOLD');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);

        Item::factory()->create([
            'seller_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
    }
}
