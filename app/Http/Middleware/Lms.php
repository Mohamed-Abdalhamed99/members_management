<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Lms
{
    /**
     * This middlware have no use unless filter routes for permission for tenants to void adding dashboard and admin routes to tenant routes
     * check PermissionMiddlewared to see why we use it
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
