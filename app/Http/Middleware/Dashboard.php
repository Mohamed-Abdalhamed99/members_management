<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Dashboard {
    /**
    * This middlware have no use unless filter routes for permission for admin to void adding tenant routes to dashboard permissions
    * check PermissionMiddlewared to see why we use it
    */
    public function handle( Request $request, Closure $next ): Response {
        return $next( $request );
    }
}
