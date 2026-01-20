<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 名前が未入力だとバリデーションエラー()
    {
        $response = $this->post(route('register'), [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'user_name' => 'お名前を入力してください'
        ]);
    }

    /** @test */
    public function メールアドレスが未入力だとバリデーションエラー()
    {
        $response = $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** @test */
    public function パスワードが未入力だとバリデーションエラー()
    {
        $response = $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** @test */
    public function パスワードが7文字以下だとエラー()
    {
        $response = $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    /** @test */
    public function パスワードと確認用パスワードが一致しない場合エラー()
    {
        $response = $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpass',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);
    }

    /** @test */
    public function 正しい情報で登録するとメール認証誘導画面（プロフィール編集画面）に遷移()
    {
        $response = $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertDatabaseHas('profiles', [
            'user_id' => User::where('email', 'test@example.com')->first()->id,
            'user_name' => 'テスト太郎',
        ]);
    }
}
