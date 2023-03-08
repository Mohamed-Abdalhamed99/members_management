<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddlewared
{
    use HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission = null, $guard = 'api'): Response
    {

        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (! is_null($permission)) {
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
        }

        if ( is_null($permission) ) {
            $permission = $request->route()->getName();

            $permissions = array($permission);
        }

        if (in_array($permissions[0] , $authGuard->user()->getAllPermissions()->pluck('name')->toArray())) {
            return $next($request);
        }

        return $this->responseForbidden('User not have permission to access this route');
    }

}
