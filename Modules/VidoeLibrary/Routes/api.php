<?php

use Illuminate\Http\Request;
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


Route::middleware(['create_permissions','auth:sanctum' , 'dashboard'])->group(function () {
    Route::apiResource('video_library' , Modules\VidoeLibrary\Http\Controllers\VidoeLibraryController::class);

});


Route::as('lms.')->prefix('lms')->middleware([
    'create_permissions', 'api', 'check_language', 'json.response', 'lms',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::apiResource('video_library' , Modules\VidoeLibrary\Http\Controllers\VidoeLibraryController::class);
});
