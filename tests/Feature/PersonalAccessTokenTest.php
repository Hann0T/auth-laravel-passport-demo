<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PersonalAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $response = Http::acceptJson()
            ->post(
                'http://localhost/api/personal/token/issue',
                [
                    'email' => 'student@example.com',
                    'password' => 'password',
                    'scopes' => 'view-grades'
                ]
            );
        $data = $response->json();
        $this->token = $data['access_token'];
    }

    /** @test */
    public function can_get_the_token_with_a_valid_user()
    {
        $response = Http::acceptJson()
            ->post(
                'http://localhost/api/personal/token/issue',
                [
                    'email' => 'test@example.com',
                    'password' => 'password',
                ]
            );

        $this->assertNotNull($response->json());
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function can_only_see_its_own_grades_with_token_and_valid_scope()
    {
        $grade = \App\Models\Grade::factory()->create([
            'user_id' => 12131
        ]);

        $response = Http::acceptJson()
            ->withToken($this->token)
            ->get('http://localhost/api/personal/grades');

        $this->assertEquals(200, $response->status());
        $this->assertNotContains($grade, $response->json());
    }

    /** @test */
    public function admin_can_view_all_grades_with_token_and_valid_scope()
    {
        $response = Http::acceptJson()
            ->post(
                'http://localhost/api/personal/token/issue',
                [
                    'email' => 'test@example.com',
                    'password' => 'password',
                    'scopes' => 'view-grades'
                ]
            );
        $token = $response->json()['access_token'];

        $response = Http::acceptJson()
            ->withToken($token)
            ->get('http://localhost/api/personal/grades');

        $this->assertEquals(200, $response->status());
    }
}
