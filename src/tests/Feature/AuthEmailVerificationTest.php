<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class AuthEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 会員登録後に認証メールが送信される()
    {
        Notification::fake();

        $this->post(route('register'), [
            'user_name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo(
                $user,
                VerifyEmail::class
        );
    }

    /** @test */
    public function メール認証誘導画面で「認証はこちらから」ボタンを押すとメール認証サイトに遷移する()
    {
        $response = $this->get(route('verification.notice'));

        $response->assertStatus(200);

        $response->assertSee('認証はこちらから');

        $response->assertSee('href="http://localhost:8025"', false);
    }

    /** @test */
    public function 認証リンクにアクセスするとメール認証が完了する()
    {
        $user = User::factory()->unverified()->create();

        Profile::factory()->create([
            'user_id' => $user->id
        ]);

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test */
    public function メール認証完了後にプロフィール編集画面へ遷移する()
    {
        $user = User::factory()->unverified()->create();
        Profile::factory()->create(['user_id' => $user->id]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('mypage.profile.edit'));
    }
}
