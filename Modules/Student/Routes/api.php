<?php

use Illuminate\Http\Request;
use Modules\Student\Http\Controllers\StudentController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::as('lms.')->prefix('lms')->middleware([
    'create_permissions', 'api', 'check_language', 'json.response' , 'lms' ,
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware('auth:sanctum')->group(function (){
        Route::apiResource('students' , StudentController::class);
    });
});
