<?php

namespace App\Http\Controllers\CentralApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateTenantsRequest;
use App\Http\Resources\TenantResource;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;

class TenantController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tenants = QueryBuilder::for ( Tenant::class )
        ->defaultSort( '-created_at' )
        ->allowedSorts( [ 'id' , 'data' ,'first_name' , 'email' , 'mobile' , 'last_name' ] )
        ->allowedFilters( [ 'id' , 'data' ,'first_name' , 'email' , 'mobile' , 'last_name' ] )
        ->paginate( \request()->pages ?? 25 )
        ->appends( request()->query() );

        return $this->respond( TenantResource::collection( $tenants )->response()->getData( true ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTenantsRequest $request)
    {

        $tenant = Tenant::create([
            'id' => $request->domain,
            'domain' => $request->domain,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        $tenant->domains()->create(['domain' => $request->domain . '.' . config('tenancy.central_domains')[0]]);

        $tenant->run(function () use ($tenant , $request) {

        // create super_admin role and give permissions to it
        $role = Role::create(['name' => 'super_admin' , 'guard_name'=>'api' ]);

        // create permissions
        $routes = Route::getRoutes()->getRoutes();
        foreach ( $routes as $route ) {
            if ( $route->getName() != '' && array_key_exists( 'middleware', $route->getAction() ) && in_array( 'lms', $route->getAction()[ 'middleware' ] ) ) {
                $permission = Permission::where( 'name', $route->getName() )->exists();
                if ( !$permission ) {
                    $permission = Permission::create( [
                        'name' => $route->getName(),
                        'guard_name' => 'api'
                    ] );

                    $role->givePermissionTo($permission->name);
                }
            }
        }

        // creat admin with tenant info
        $tenantAdmin = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile
        ]);

        // assign super_admin role to the admin
        $tenantAdmin->assignRole($role->name);

        return $this->responseOk('تم إنشاء نطاق جديد');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       Tenant::where('id' , $id)->delete();

        return $this->responseOk('تم الحذف بنجاح');
    }
}
