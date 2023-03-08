<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = QueryBuilder::for(Role::class)
            ->where('name', '!=', 'super_admin')
            ->defaultSorts('-created_at')
            ->allowedSorts(['name'])
            ->allowedFilters(['name'])
            ->paginate()
            ->appends($request->query());

        return $this->respond(['roles' => RoleResource::collection($roles)->response()->getData(true)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo(Permission::findById($permission)->name);
        }
        return $this->responseCreated(new RoleResource($role), 'Role Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->respond(new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions($request->permissions);


        return $this->responseCreated(new RoleResource($role), 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission->name);
        }
        $role->delete();
        return $this->responseOk('Role Deleted Successfully');
    }

    /**
     * get permissions for selecting when create roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllowedPermissions()
    {
        $permissions = PermissionResource::collection(Permission::get());
        return $this->respond($permissions);
    }
}
