<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MypageProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 変更項目が初期値として表示されている()
    {
        $user = User::factory()->create();

        $user->Profile->update([
            'user_name' => '初期ユーザー名',
            'post_num' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
            'image' => 'profile/sample.png',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('初期ユーザー名');
        $response->assertSee('123-4567');
        $response->assertSee('東京都新宿区');
        $response->assertSee('テストビル');
        $response->assertSee('profile/sample.png');
    }
}
