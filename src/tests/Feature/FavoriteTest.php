<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねアイコンを押すことによっていいねした商品として登録できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('items.favorite', $item->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.show', $item->id));
        $response->assertSee('1');
    }

    /** @test */
    public function 追加済みのアイコンは色が変化する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('items.favorite', $item->id));

        $response = $this->get(route('items.show', $item->id));
        $response->assertSee('heart_pink.png');
        $response->assertDontSee('heart_def.png');
    }

    /** @test */
    public function 再度いいねアイコンを押すことによっていいねを解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('items.favorite', $item->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.show', $item->id));
        $response->assertSee('heart_def.png');
        $response->assertSee('0');
    }

    /** @test */
    public function ログイン前はいいねできない()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('items.favorite', $item->id));

        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('favorites', [
            'item_id' => $item->id,
        ]);
    }
}