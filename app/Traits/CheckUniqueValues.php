<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

trait CheckUniqueValues {

    public function checkUniqueValues( $model, $key , $value ) : bool {
        $model = '\\App\Models\\' . $model;
        return $model::where( $key, $value )->exists();
    }
}
