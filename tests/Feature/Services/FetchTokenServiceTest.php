<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\FetchTokenService;
use Tests\TestCase;

class FetchTokenServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FetchTokenService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new FetchTokenService();
    }

    /** @test */
    public function service_should_return_a_token()
    {
        $token = $this->service->getToken();

        $this->assertNotEmpty($token);
    }

    /** @test */
    public function service_should_return_a_the_same_token_if_the_token_not_expire_yet()
    {
        $token = $this->service->getToken();

        $this->assertNotEmpty($token);

        $newToken = $this->service->getToken();

        $this->assertEquals($token, $newToken);
    }

    /** @test */
    public function with_scopes_should_return_the_same_instance()
    {
        $sameInstance = $this->service->withScopes(['scope-1']);
        $this->assertSame($this->service, $sameInstance);
    }

    /** @test */
    public function format_scopes_should_return_a_valid_string_of_scopes()
    {
        $scopesFormated = $this->service->formatScopes(['scope-1', 'scope-2']);

        $this->assertEquals('scope-1 scope-2', $scopesFormated);
    }

    /** @test */
    public function service_should_return_a_token_with_valid_scopes()
    {
        $token = $this->service
            ->withScopes(['scope-1', 'scope-2'])
            ->getToken();

        $this->assertNotEmpty($token);
    }
}
