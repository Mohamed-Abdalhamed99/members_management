<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionsMiddleware {

    use HttpResponse;

    /**
    * Handle an incoming request.
    *
    * @param  \Closure( \Illuminate\Http\Request ): ( \Symfony\Component\HttpFoundation\Response )  $next
    */
    public function handle( $request, Closure $next, $permission = null, $guard = null ) {
        $authGuard = app( 'auth' )->guard( $guard );

        if ( $authGuard->guest() ) {
            throw UnauthorizedException::notLoggedIn();
        }

        if ( $permission != null ) {
            $permissions = is_array( $permission )
            ? $permission
            : explode( '|', $permission );

            foreach ( $permissions as $permission ) {
                if ( $authGuard->user()->can( $permission ) ) {
                    return $next( $request );
                }
            }
        }

        //get cuurent route name
        $route = Route::current()->getName();

        if($authGuard->user()->can( $route )){
            return $next( $request );
        }
        return $this->responseForbidden("this user doesn't have the right premission for this action");
        throw UnauthorizedException::forPermissions( ($permission != null) ? $permissions : [ $route] );
    }
}
