<?php

namespace App\Http\Controllers\CentralApp\Auth\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckDomainController extends Controller
{

    use HttpResponse;

    /**
     * when tenant login from central app we ask him to enter domain
     * check if domain is right and exists the return message to call the API with tenant domain from front end App
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        $tenant = Domain::where('tenant_id' , $request->domain)->first();

        if($tenant != null){
            return $this->respond([
                'message' => 'The domain is correct',
                'domain' => $tenant->tenant_id
            ]);
        }

        return $this->responseUnProcess('This domain is incorrect');
    }
}
