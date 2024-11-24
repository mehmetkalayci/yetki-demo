<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DynamicPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission, $modelClass = null): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Giriş yapmanız gerekiyor.');
        }

        if ($user->hasRole('süper-admin')) {
            return $next($request);
        }

        // Model varsa, örneğini bul
        $model = $modelClass ? $modelClass::find($request->route('id')) : null;

        if (!$user->hasPermission($permission, $model)) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        return $next($request);
    }
}
