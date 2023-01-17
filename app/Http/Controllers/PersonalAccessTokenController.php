<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalAccessTokenController extends Controller
{
    public function getToken(Request $request): array
    {
        $user = User::where('email', $request->email)
            ->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return ['unauthorized'];
        }

        if ($request->scopes) {
            $scopes = explode(' ', $request->scopes);
            return ['access_token' => $user->createToken('Token Name', $scopes)->accessToken];
        }

        return ['access_token' => $user->createToken('Token Name')->accessToken];
    }
}
