<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class ItemSellTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品出品画面にて必要な情報が保存できる()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $categories = Category::factory()->count(2)->create();
        $condition = Condition::factory()->create();

        $this->actingAs($user);

        $image = UploadedFile::fake()->create(
            'item.jpeg',
            100,
            'image/jpeg'
        );

        $response = $this->post(route('items.store'), [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'detail' => '商品説明テスト',
            'price' => 5000,
            'condition' => $condition->id,
            'categories' => $categories->pluck('id')->toArray(),
            'image' => $image,
        ]);

        $item = Item::first();
        $this->assertNotNull($item);

        $response->assertRedirect(route('items.show', $item->id));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'detail' => '商品説明テスト',
            'price' => 5000,
            'condition_id' => $condition->id,
            'seller_id' => $user->id,
        ]);

        $this->assertNotNull($item->image);

        Storage::disk('public')->assertExists($item->image);

        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $item->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
