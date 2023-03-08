<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VerificationEnum;
use App\Http\Requests\Admin\CreateTenantsRequest;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\Tenant;
use App\Models\Token;
use App\Models\User;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class TenantController extends Controller
{

    use HttpResponse , StoreFile;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tenants = QueryBuilder::for(Tenant::class)
            ->defaultSorts('-created_at')
            ->allowedSorts(['-deleted_at', 'first_name', 'last_name', 'email', 'telephone'])
            ->allowedFilters(['first_name', 'last_name', 'email', 'telephone'])
            ->paginate()
            ->appends($request->query());

        return $this->respond(['tenants' => TenantResource::collection($tenants)->response()->getData(true)]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTenantsRequest $request)
    {
        $data = $request->validated();
        $data['id'] = Str::slug($request->company_name);
        if($request->avatar){
            $data['avatar'] = $this->storeFile($request->avatar , 'media/users');
        }
        $newTenant = Tenant::create($data);
        $newTenant->domains()->create(['domain' => $request->domain . '.' . config('tenancy.central_domains')[0]]);

        // create permissions
        $permissions = $newTenant->plans->permissions;
        $newTenant->run(function () use ($permissions, $newTenant , $request) {
            //create roles and assign permission to the role
            $role = Role::create(['name' => 'super_admin', 'guard_name' => 'api']);
            foreach ($permissions as $permission) {

                Permission::create([
                    'name' => $permission->name,
                    'display_name_ar' => $permission->display_name_ar,
                    'display_name_en' => $permission->display_name_en,
                    'guard_name' => $permission->guard_name,
                    'route' => $permission->route,
                    'module' => $permission->module,
                    'as' => $permission->as,
                    'icon' => $permission->icon,
                    'appear' => $permission->appear,
                    'ordering' => $permission->ordering
                ]);

                $role->givePermissionTo($permission->name);
            }

            $tenantAdmin = User::create([
                'first_name' => $newTenant->first_name,
                'last_name' => $newTenant->last_name,
                'email' => $newTenant->email,
                'password' => Hash::make($newTenant->password),
                'telephone' => $newTenant->telephone,
                'address' => $newTenant->address,
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

            // create company
            $company = [
                'name' => $request->company_name,
                'email' => $request->company_email,
                'phone' => $request->company_phone,
                'fax' => $request->company_fax,
                'website' => $request->company_website,
                'bank' => $request->company_bank,
                'bank_account' => $request->company_bank_account,
                'notes' => $request->company_notes,
                'fiscal_code' => $request->company_fiscal_code,
            ];

            if($request->company_logo){
                $company['logo'] = $this->storeFile($request->logo , 'media/companies');
            }
            $company = Company::create($company);
        });

        return $this->respond(new TenantResource($newTenant));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return $this->respond(new TenantResource($tenant) );
    }
}
