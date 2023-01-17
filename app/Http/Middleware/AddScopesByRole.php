<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AddScopesByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->email)
            ->first();

        if (!$user) {
            return abort(401);
        }

        $request->scopes = 'view-grades';

        if ($user->isAdmin() || $user->isTeacher()) {
            $request->scopes = $request->scopes . ' ' . 'update-grades';
        }

        return $next($request);
    }
}
