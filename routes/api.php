<?php

use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\RoleController;
use \App\Http\Controllers\Admin\PlansController;
use \App\Http\Controllers\Admin\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    dd('central app');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// central dashboard authentication
Route::prefix('/dashboard')->as('dashboard.')->group(function () {
   Route::namespace('App\Http\Controllers\CentralApp\Auth\Dashboard')->group(function (){
       Route::post('/login', LoginController::class)->name('login.api');
       Route::delete('/logout', LogoutController::class)->name('logout.api')->middleware('auth:sanctum');
       Route::post('/forget-password', ForgotPasswordController::class)->name('requestPasswordToken.api');
       Route::patch('/reset-password', ResetPasswordController::class)->name('resetPassword.api');
   });

    Route::middleware(['auth:sanctum', 'permission'])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
    });

});

// tenant authentication
Route::prefix('accounts')->namespace('App\Http\Controllers\CentralApp\Auth\Tenant')->as('accounts.')->group(function () {
    Route::post('check-domain' , CheckDomainController::class)->name('check_domain');
    Route::post('/register', 'RegistrationController@register')->name('register.api');

});


Route::apiResource('tenants', TenantController::class);





Route::get('test' , function (){
    return asset('media_library/cfd21b47a542828023a1fef502e0f872.jpg');
});
