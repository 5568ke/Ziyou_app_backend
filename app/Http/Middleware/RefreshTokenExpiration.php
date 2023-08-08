<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class RefreshTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // 检查当前用户是否已经通过 Sanctum 身份验证
        if (Auth::guard('web')->check() || Auth::guard('sanctum_teacher')->check() || Auth::guard('sanctum_student')->check()) {
            $user = Auth::user();
            $token = $user->currentAccessToken();
            $token->forceFill([
                'expires_at' => now()->addMinutes(30),
            ])->save();
        }
        return $response;
    }
}
