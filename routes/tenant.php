<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\TenantApp\Auth\EmailVerificationController;
use App\Http\Controllers\TenantApp\Auth\ForgotPasswordController;
use App\Http\Controllers\TenantApp\Auth\LoginController;
use App\Http\Controllers\TenantApp\Auth\LogoutController;
use App\Http\Controllers\TenantApp\Auth\ResetPasswordController;
use App\Http\Controllers\TenantApp\Auth\SendEmailVerificationTokenController;
//use \App\Http\Controllers\Admin\UserController;
//use \App\Http\Controllers\Admin\RoleController;
use \App\Http\Controllers\Admin\PlansController;
use \App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\CentralApp\Auth\Dashboard\MobileLoginController;
use App\Http\Controllers\CentralApp\RoleController;
use App\Http\Controllers\CentralApp\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

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
Route::as('lms.')->prefix('v1/api/lms')->middleware([

    'create_permissions', 'api', 'check_language' , 'json.response', 'lms',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,

])->group(function () {
    Route::post('send-opt' , [MobileLoginController::class , 'sendOPT'])->name('send-opt');
    Route::post('mobile-login' , [MobileLoginController::class , 'mobileLogin'])->name('mobile-login');
    Route::post('verify-mobile' , [MobileLoginController::class , 'verifyMobile'])->name('verify-mobile');
    Route::post('/login', LoginController::class)->name('login.api');
    Route::delete('/logout', LogoutController::class)->name('logout.api')->middleware('auth:sanctum');
    // Route::post('/register', RegistrationController::class)->name('register.api');
    Route::post('/verify-email', EmailVerificationController::class)->name('verifyToken.api');
    Route::post('/request-email-token', SendEmailVerificationTokenController::class)->name('requestEmailToken.api');
    Route::post('/forget-password', ForgotPasswordController::class)->name('requestPasswordToken.api');
    Route::patch('/reset-password', ResetPasswordController::class)->name('resetPassword.api');

    Route::middleware([ 'auth:sanctum', 'permission'])->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::get('permissions' , [RoleController::class , 'getPermissions'])->name('permissions.read')->middleware('permission:dashboard.permissions.read');
        Route::apiResource('users', UserController::class);
        Route::put('change-user-password/{user}' , [UserController::class , 'changePassword'])->name('change-user-password');
    });

});
