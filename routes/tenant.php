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




Route::as('lms.')->prefix('v1/api/lms')->middleware([
    'api', 'check_language' , 'json.response',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/' , function (){dd('tenant app');});
    Route::post('/login', LoginController::class)->name('login.api');
    Route::delete('/logout', LogoutController::class)->name('logout.api')->middleware('auth:sanctum');
    Route::post('/register', RegistrationController::class)->name('register.api');
    Route::post('/verify-email', EmailVerificationController::class)->name('verifyToken.api');
    Route::post('/request-email-token', SendEmailVerificationTokenController::class)->name('requestEmailToken.api');
    Route::post('/forget-password', ForgotPasswordController::class)->name('requestPasswordToken.api');
    Route::patch('/reset-password', ResetPasswordController::class)->name('resetPassword.api');

    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
});
