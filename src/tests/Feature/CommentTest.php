<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みのユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);
        
        $response = $this->post(route('items.comment', $item->id), [
            'detail' => 'テストコメント',
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'detail' => 'テストコメント',
        ]);
    }

    /** @test */
    public function ログイン前のユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('items.comment', $item->id), [
            'detail' => 'コメント不可',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', [
            'detail' => 'コメント不可',
        ]);
    }

    /** @test */
    public function コメントが入力されていない場合バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('items.comment', $item->id), [
            'detail' => '',
        ]);

        $response->assertSessionHasErrors('detail');
    }

    /** @test */
    public function コメントが255字以上の場合バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $longText = str_repeat('あ', 256);

        $response = $this->post(route('items.comment', $item->id), [
            'detail' => $longText,
        ]);

        $response->assertSessionHasErrors('detail');
    }
}