<?php

namespace App\Http\Controllers\CentralApp\Auth\Tenant;

use App\Enums\VerificationEnum;
use App\Http\Requests\CentralApp\RegistrationTenantFormRequest;
use App\Http\Resources\TenantResource;
use App\Models\Company;
use App\Models\Tenant;
use App\Models\Token;
use App\Models\User;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegistrationController
{
    use HttpResponse , StoreFile;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(RegistrationTenantFormRequest $request)
    {
        $data = $request->validated();

        $newTenant = Tenant::create([
            'id' => $request->domain,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);
        $newTenant->domains()->create(['domain' => $request->domain . '.' . config('tenancy.central_domains')[0]]);

        // create permissions
        $permissions = Permission::where('app' , 'tenant_app')->get();

        $newTenant->run(function () use ($permissions, $newTenant , $request) {
            //create roles and assign permission to the role
            $role = Role::create(['name' => 'super_admin', 'guard_name' => 'api']);
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission->name, 'display_name_ar' => $permission->display_name_ar, 'display_name_en' => $permission->display_name_en, 'guard_name' => $permission->guard_name, 'route' => $permission->route, 'module' => $permission->module, 'as' => $permission->as, 'icon' => $permission->icon, 'appear' => $permission->appear, 'ordering' => $permission->ordering]);

                $role->givePermissionTo($permission->name);
            }

            $tenantAdmin = User::create([
                'first_name' => $newTenant->first_name,
                'last_name' => $newTenant->last_name,
                'email' => $newTenant->email,
                'password' => Hash::make($request->password)
                //    'avatar' => $this->storeFile($request->logo , 'media/companies')
            ]);
            $tenantAdmin->assignRole($role->name);

            // create token and send email verification
            $tokenData = Token::create([
                'token' =>  generateToken(),
                'email' => $request->email,
                'type' => VerificationEnum::Email
            ]);

            $newTenant->notify(new SendEmailTokenNotification($tokenData->token));

        });

        return $this->respond(new TenantResource($newTenant));
    }




}
