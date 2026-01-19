<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 住所変更画面で登録した住所が購入画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->put(route('purchase.address.update', $item->id), [
            'post_num' => '111-2222',
            'address' => '東京都千代田区',
            'building' => 'テストマンション',
        ]);

        $response = $this->get(route('purchase.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('111-2222');
        $response->assertSee('東京都千代田区');
        $response->assertSee('テストマンション');
    }

    /** @test */
    public function 購入時に変更した住所が商品に紐づいて保存される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('purchase.address.update', $item->id), [
            'post_num' => '999-8888',
            'address' => '大阪府大阪市',
            'building' => '購入用住所',
        ]);

        $this->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
            'post_num' => '999-8888',
            'address' => '大阪府大阪市',
            'building' => '購入用住所',
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'post_num' => '999-8888',
            'address' => '大阪府大阪市',
            'building' => '購入用住所',
        ]);
    }
}
