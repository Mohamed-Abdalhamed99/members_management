
<?php

use Illuminate\Http\Request;
use Modules\Product\Http\Controllers\ProductController;
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


Route::middleware(['auth:sanctum' , 'dashboard'])->group(function () {

});


Route::as('lms.')->prefix('lms')->middleware([
    'api', 'check_language', 'json.response' , 'lms',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware('auth:sanctum')->group(function (){
        Route::apiResource('products' , \Modules\Product\Http\Controllers\ProductController::class);
        Route::delete('delete-product-media/{media}' , [ProductController::class ,'deleteProductMedia'])->name('delete-product-media');
    });


});
