<?php

namespace App\Http\Controllers\CentralApp\Auth\Tenant;

use App\Enums\VerificationEnum;
use App\Http\Requests\CentralApp\RegistrationTenantFormRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\Token;
use App\Models\User;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use App\Traits\TwilioSMS;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

class RegistrationController
{
    use HttpResponse , StoreFile , TwilioSMS;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(RegistrationTenantFormRequest $request)
    {
        $data = $request->validated();

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

          $opt = generateToken();

          try{
              $this->SendSMS($request->mobile , ' رمز التحقق أكاديميات ' . $opt);
          }catch(Exception $e){
              return $this->responseUnProcess($e->getMessage());
          }

          Token::create( [
              'token' =>  $opt,
              'mobile' => $request->mobile,
              'type' => VerificationEnum::MOBILE
          ] );

        });



        return $this->responseOk( 'تم ارسال رسالة التحقق من رقم الجوال' );
    }


}
