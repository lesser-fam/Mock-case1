<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function メールアドレスが未入力だとバリデーションエラー()
    {
        $response = $this->post(route('login'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
            ]);
    }

    /** @test */
    public function パスワードが未入力だとバリデーションエラー()
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** @test */
    public function 入力情報が間違っている場合はエラー()
    {
        $response = $this->post(route('login'), [
            'email' => 'notfound@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません'
        ]);
    }

    /** @test */
    public function 正しい情報でログインできる()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/?tab=mylist');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function 未認証ユーザーはログインできず認証誘導画面に遷移する()
    {
        $user = User::factory()->unverified()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();

        $response->assertRedirect(route('verification.notice'));
    }
}