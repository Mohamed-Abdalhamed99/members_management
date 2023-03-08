<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SendEmailVerificationTokenController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\RoleController;
use \App\Http\Controllers\Admin\PlansController;
use \App\Http\Controllers\Auth\RegistrationController;
use \App\Http\Controllers\Admin\TenantController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::prefix('v1/api')->middleware([
    'api', 'check_language' , 'json.response',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::post('/login', LoginController::class)->name('login.api');
    Route::middleware(['auth:sanctum' , 'role:super_admin'])->group(function (){
        Route::apiResource('users' , \App\Http\Controllers\Admin\UserController::class);
        Route::get('allowed-permissions' , [RoleController::class , 'getAllowedPermissions']);
    });
    Route::delete('/logout', LogoutController::class)->name('logout.api')->middleware('auth:sanctum');
    Route::post('/register', RegistrationController::class)->name('register.api');
    Route::post('/verify-email', EmailVerificationController::class)->name('verifyToken.api');
    Route::post('/request-email-token', SendEmailVerificationTokenController::class)->name('requestEmailToken.api');
    Route::post('/forget-password', ForgotPasswordController::class)->name('requestPasswordToken.api');
    Route::patch('/reset-password', ResetPasswordController::class)->name('resetPassword.api');

    Route::middleware(['auth:sanctum' , 'permission'])->group(function () {
        Route::apiResource('users' , UserController::class);
        Route::apiResource('roles' , RoleController::class);
    });

});
