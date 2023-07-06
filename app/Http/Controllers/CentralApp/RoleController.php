<?php

namespace App\Http\Controllers\CentralApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Traits\HttpResponse;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller {
    use HttpResponse;

    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index() {
        $roles = QueryBuilder::for ( Role::class )
        ->defaultSort( '-created_at' )
        ->allowedSorts( [ 'name' ] )
        ->allowedFilters( [ 'name'] )
        ->paginate( \request()->pages ?? 25 )
        ->appends( request()->query() );

        return $this->respond( RoleResource::collection( $roles )->response()->getData( true ) );
    }

    /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Renderable
    */
    public function store( CreateRoleRequest $request ) {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);
        $role->syncPermissions($request->permissions);
        return $this->responseOk('تم إضافة الدور بنجاح');
    }

    /**
    * Show the specified resource.
    * @param int $id
    * @return Renderable
    */
    public function show( Role $role ) {
        $data = new RoleResource( $role );
        return $this->respond( $data );
    }

    /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Renderable
    */
    public function update( UpdateRoleRequest $request, Role $role ) {
        $role->update([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);
        $role->syncPermissions($request->permissions);
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Renderable
    */
    public function destroy( Role $role ) {
        $role->delete();
        return $this->responseOk( 'تم الحذف بنجاح' );
    }

    public function getPermissions()
    {
        return $this->respond(PermissionResource::collection(Permission::get()));
    }
}
