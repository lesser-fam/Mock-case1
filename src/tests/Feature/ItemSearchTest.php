<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        $item1 = Item::factory()->create(['name' => '赤いシャツ']);
        $item2 = Item::factory()->create(['name' => '青いシャツ']);
        $item3 = Item::factory()->create(['name' => '緑のズボン']);

        $response = $this->get('/?keyword=シャツ');

        $response->assertStatus(200);
        $response->assertSee('赤いシャツ');
        $response->assertSee('青いシャツ');
        $response->assertDontSee('緑のズボン');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
     {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => '赤いシャツ']);
        $item2 = Item::factory()->create(['name' => '青いシャツ']);

        $user->favorites()->create(['item_id' => $item1->id]);

        $response = $this->get('/?keyword=シャツ');

        $response->assertStatus(200);
        $response->assertSee('赤いシャツ');
        $response->assertSee('青いシャツ');

        $response->assertSee('?tab=mylist&amp;keyword=シャツ', false);

        $mylistResponse = $this->get('/?tab=mylist&keyword=シャツ');

        $mylistResponse->assertStatus(200);
        $mylistResponse->assertSee('赤いシャツ');
        $mylistResponse->assertDontSee('青いシャツ');

        $mylistResponse->assertSee('value="シャツ"', false);
    }
}