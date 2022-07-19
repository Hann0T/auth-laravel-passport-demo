<?php

namespace App\Services;

use App\Contracts\Services\FetchToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FetchTokenService implements FetchToken
{
    protected array $scopes = [''];

    /**
     * @return string  $token
     */
    public function getToken(): string
    {
        $scopes = '';

        if (count($this->scopes) > 0) {
            $scopes = $this->formatScopes($this->scopes);
        }

        $token = Cache::store(env('CACHE_DRIVER'))
            ->get('service_access_token');

        if ($token) {
            return $token;
        }

        $response = Http::asForm()->post(env('TOKEN_API_URL'), [
            'grant_type' => 'client_credentials',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'scope' => $scopes,
        ]);

        $data = $response->json();

        $token = $data['access_token'];

        Cache::store(env('CACHE_DRIVER'))
            ->put('service_access_token', $token, $data['expires_in']);

        return $token;
    }

    public function withScopes(array $scopes): FetchTokenService
    {
        $this->scopes = $scopes;

        return $this;
    }

    public function formatScopes(array $scopes): string
    {
        return implode(' ', $scopes);
    }
}
