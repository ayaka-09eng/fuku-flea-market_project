<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_変更項目が初期値として過去設定されていること()
    {
        $user = User::factory()
            ->has(UserProfile::factory([
                'img_path' => 'avatars/test.png',
                'postal_code' => '123-4567',
                'address' => '東京都テスト区1-2-3',
                'building' => 'テストマンション101',
            ]), 'profile')
            ->create([
                'name' => 'テストユーザー',
            ]);

        $this->actingAs($user);

        $response = $this->get('/mypage')
            ->assertStatus(200)
            ->assertSee(route('profile.edit'));

        $response = $this->get(route('profile.edit'))
            ->assertStatus(200);

        $response->assertSee('avatars/test.png', false);

        $response->assertSee('value="テストユーザー"', false);

        $response->assertSee('value="123-4567"', false);

        $response->assertSee('value="東京都テスト区1-2-3"', false);

        $response->assertSee('value="テストマンション101"', false);
    }
}
