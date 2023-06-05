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

Route::middleware('auth:api')->get('/medialibrary', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-uploaded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getUploadedFiles']);
    Route::get('get-embedded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getEmbeddedFiles']);
    Route::post('embed-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'embedFile']);
    Route::post('update-embed-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateEmbeddedFile']);
    Route::post('updated-uploaded-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateUploadedFile']);
    Route::post('upload-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'uploadFile']);
    Route::delete('delete-uploaded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteUploadedFiles']);
    Route::delete('delete-embedded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteEmbeddedFiles']);
});

Route::as('lms.')->prefix('lms')->middleware([
    'api', 'check_language', 'json.response',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
//    Route::middleware('auth:sanctum')->get('/course', function (Request $request) {
//        return $request->user();
//    });


    Route::get('get-uploaded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getUploadedFiles']);
    Route::get('get-embedded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getEmbeddedFiles']);
    Route::post('embed-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'embedFile']);
    Route::post('update-embed-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateEmbeddedFile']);
    Route::post('updated-uploaded-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateUploadedFile']);
    Route::post('upload-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'uploadFile']);
    Route::delete('delete-uploaded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteUploadedFiles']);
    Route::delete('delete-embedded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteEmbeddedFiles']);

});
