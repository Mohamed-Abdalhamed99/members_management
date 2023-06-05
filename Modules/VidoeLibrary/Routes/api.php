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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('video_library' , Modules\VidoeLibrary\Http\Controllers\VidoeLibraryController::class);

});


Route::as('lms.')->prefix('lms')->middleware([
    'api', 'check_language', 'json.response',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::apiResource('video_library' , Modules\VidoeLibrary\Http\Controllers\VidoeLibraryController::class);
});
