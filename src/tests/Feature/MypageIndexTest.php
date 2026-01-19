<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class MypageIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィールに必要な情報が取得できる()
    {
        $user = User::factory()->create();
        
        $user->profile->update([
            'user_name' => 'テストユーザー',
            'image' => 'profile/test.png',
        ]);

        $sellItem = Item::factory()->for($user, 'seller')->create([
            'name' => '出品商品',
        ]);

        $buyItem = Item::factory()->create([
            'name' => '購入商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $buyItem->id,
            'buyer_id' => $user->id,
            'status' => 'paid',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage.index', ['page' => 'sell']));
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品商品');

        $response = $this->get(route('mypage.index', ['page' => 'buy']));
        $response->assertStatus(200);
        $response->assertSee('購入商品');
        $response->assertSee('SOLD');
    }
}
