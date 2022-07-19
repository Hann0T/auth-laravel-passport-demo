<?php

namespace App\Contracts\Services;

interface FetchToken
{
    /**
     * @return string  $token
     */
    public function getToken(): string;
    public function withScopes(array $scopes): FetchToken;
}
