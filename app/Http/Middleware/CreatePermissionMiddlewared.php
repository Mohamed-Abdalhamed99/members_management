<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class CreatePermissionMiddlewared {
    use HttpResponse;
    /**
    * This middleware use to store permissions in database
    *
    */

    public function handle( Request $request, Closure $next ) {
        $routes = Route::getRoutes()->getRoutes();
        if ( tenant() ) {
            foreach ( $routes as $route ) {
                if ( $route->getName() != '' && array_key_exists( 'middleware', $route->getAction() ) && in_array( 'lms', $route->getAction()[ 'middleware' ] ) ) {
                    $permission = Permission::where( 'name', $route->getName() )->exists();
                    if ( !$permission ) {
                        $permission = Permission::create( [
                            'name' => $route->getName(),
                            'guard_name' => 'api'
                        ] );
                        $role = Role::where('name' , 'super_admin')->first();
                        $role->givePermissionTo($permission->name);
                    }

                }
            }
        } else {
            foreach ( $routes as $route ) {
                if ( $route->getName() != '' && array_key_exists( 'middleware', $route->getAction() ) && in_array( 'dashboard', $route->getAction()[ 'middleware' ] ) ) {
                    $permission = Permission::where( 'name', $route->getName() )->exists();
                    if ( !$permission ) {
                        $permission = Permission::create( [
                            'name' => $route->getName(),
                            'guard_name' => 'api'
                        ] );
                        $role = Role::where('name' , 'super_admin')->first();
                        $role->givePermissionTo($permission->name);
                    }

                }
            }
        }
        return $next( $request );
    }

}
