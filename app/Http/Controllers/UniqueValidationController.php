<?php

namespace App\Http\Controllers;

use App\Traits\CheckUniqueValues;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Concerns\HasUniqueIds;
use Illuminate\Http\Request;

class UniqueValidationController extends Controller {
    use HttpResponse, CheckUniqueValues;

    protected $nameSpace = '\\App\Models\\';

    /**
     * validate unique columns in users table
     * get key name and value then check if this value is exist in tha table
     *
     * @param string $key , $value
     * @return \Illuminate\Http\JsonResponse
     */
    public function valdateUniqueUsers( $key, $value ) {
        $model = 'User';
        $res = $this->checkUniqueValues( $model, $key, $value );

        if ( $res ) {
            return $this->responseBadRequest( 'this ' . $key . ' aready exists' );
        }

        return $this->responseOk( 'valid ' . $key );
    }

     /**
     * validate unique columns in tenants table
     * get key name and value then check if this value is exist in tha table
     *
     * @param string $key , $value
     * @return \Illuminate\Http\JsonResponse
     */
    public function valdateUniqueTenants( $key, $value ) {
        $model = 'Tenant';
        $res = $this->checkUniqueValues( $model, $key, $value );

        if ( $res ) {
            return $this->responseBadRequest( 'this ' . $key . ' aready exists' );
        }

        return $this->responseOk( 'valid ' . $key );
    }
}
