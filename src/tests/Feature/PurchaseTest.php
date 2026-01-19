<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 「購入する」ボタンを押すと購入が完了する()
    {
        $buyer = User::factory()->create();
        
        $item = Item::factory()->create();

        $this->actingAs($buyer);

        $response = $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'post_num' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);
    }

    /** @test */
    public function 購入した商品は商品一覧にて「SOLD」と表示される()
    {
        $buyer = User::factory()->create();
        
        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('SOLD');
    }

    /** @test */
    public function 「プロフィール／購入した商品一覧」に追加されている()
    {
        $buyer = User::factory()->create();
        
        $item = Item::factory()->create([
            'name' => '購入済み商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 'paid',
        ]);

        $this->actingAs($buyer);

        $response = $this->get(route('mypage.index', ['page' => 'buy']));

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
    }
}
