<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::apiResource('tenants' , TenantController::class);

Route::middleware(['auth:sanctum' , 'permission'])->group(function () {

    Route::apiResource('users' , UserController::class);
    Route::apiResource('roles' , RoleController::class);
    Route::apiResource('plans' , PlansController::class);
});
