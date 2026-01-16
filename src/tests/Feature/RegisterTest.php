<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_名前が入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register')->assertStatus(200);

        $data = [
            'email' => 'example@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    public function test_メールアドレスが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register')->assertStatus(200);

        $data = [
            'name' => '山田　太郎',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_パスワードが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register')->assertStatus(200);

        $data = [
            'name' => '山田　太郎',
            'email' => 'example@example.com',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_パスワードが7文字以下の場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register')->assertStatus(200);

        $data = [
            'name' => '山田　太郎',
            'email' => 'example@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    public function test_パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register')->assertStatus(200);

        $data = [
            'name' => '山田　太郎',
            'email' => 'example@example.com',
            'password' => 'pass',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }

    public function test_全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される()
    {
        $this->get('/register')->assertStatus(200);

        $data = [
            'name' => '山田　太郎',
            'email' => 'example@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register.store'), $data);
        $response->assertRedirect(route('profile.create'));

        $user = User::first();
        $user->markEmailAsVerified();

        $this->actingAs($user);

        $this->get(route('profile.create'))->assertStatus(200)->assertViewIs('users.create');
    }
}
