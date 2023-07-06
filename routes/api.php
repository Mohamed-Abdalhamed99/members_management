<?php

use App\Http\Controllers\CentralApp\Auth\Dashboard\MobileLoginController;
use App\Http\Controllers\CentralApp\PlanController;
use App\Http\Controllers\CentralApp\RoleController;
use App\Http\Controllers\CentralApp\TenantController;
use App\Http\Controllers\CentralApp\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// central dashboard authentication
Route::prefix('/dashboard')->as('dashboard.')->group(function () {
   Route::namespace('App\Http\Controllers\CentralApp\Auth\Dashboard')->group(function (){
       Route::post('/login', LoginController::class)->name('login.api');
       Route::post('send-opt' , [MobileLoginController::class , 'sendOPT'])->name('send-opt');
       Route::post('mobile-login' , [MobileLoginController::class , 'mobileLogin'])->name('mobile-login');
       Route::post('verify-mobile' , [MobileLoginController::class , 'verifyMobile'])->name('verify-mobile');
       Route::delete('/logout', LogoutController::class)->name('logout.api')->middleware(['auth:sanctum' , 'dashboard']);
       Route::post('/forget-password', ForgotPasswordController::class)->name('requestPasswordToken.api');
       Route::patch('/reset-password', ResetPasswordController::class)->name('resetPassword.api');
   });

    Route::middleware(['dashboard' , 'auth:sanctum', 'permission'])->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::get('permissions' , [RoleController::class , 'getPermissions'])->name('permissions.read')->middleware('permission:dashboard.permissions.read');
        Route::apiResource('users', UserController::class);
        Route::put('change-user-password/{user}' , [UserController::class , 'changePassword'])->name('change-user-password');
        Route::apiResource('tenants', TenantController::class);
        Route::apiResource('plans', PlanController::class);
        Route::put('update-plan-feature/{plans_feature}' , [PlanController::class , 'updatePlanFeature'])->name('update-plan-feature');
        Route::delete('delete-plan-feature/{plans_feature}' , [PlanController::class , 'deletePlanFeature'])->name('delete-plan-feature');
    });
});

// tenant authenticati  on
Route::prefix('accounts')->namespace('App\Http\Controllers\CentralApp\Auth\Tenant')->as('accounts.')->group(function () {
    Route::post('check-domain' , CheckDomainController::class)->name('check_domain');
    Route::post('/register', 'RegistrationController@register')->name('register.api');
});


// Route::apiResource('tenants', TenantController::class);


Route::middleware('create_permissions')->get('test' , function (){
    dd('central app');
});
