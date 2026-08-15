<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $hasPermission =
            (method_exists($user, 'hasPermission') && $user->hasPermission($permission)) ||
            (method_exists($user, 'hasPermissionTo') && $user->hasPermissionTo($permission)) ||
            (method_exists($user, 'can') && $user->can($permission));

        if (!$hasPermission) {
            abort(403, 'Anda tidak mempunyai hak akses.');
        }

        return $next($request);
    }
}
