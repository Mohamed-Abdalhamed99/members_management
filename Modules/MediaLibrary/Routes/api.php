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



Route::middleware(['create_permissions','auth:api' , 'dashboard'])->group(function () {
    Route::get('get-uploaded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getUploadedFiles'])->name('get-uploaded-files');
    Route::get('get-embedded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getEmbeddedFiles'])->name('get-embedded-files');
    Route::post('embed-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'embedFile'])->name('embed-file');
    Route::post('update-embed-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateEmbeddedFile'])->name('update-embed-file');
    Route::post('updated-uploaded-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateUploadedFile'])->name('updated-uploaded-file');
    Route::post('upload-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'uploadFile'])->name('upload-file');
    Route::delete('delete-uploaded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteUploadedFiles'])->name('delete-uploaded-files');
    Route::delete('delete-embedded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteEmbeddedFiles'])->name('delete-embedded-files');
});

Route::as('lms.')->prefix('lms')->middleware([
    'create_permissions','api', 'check_language', 'json.response','lms',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('get-uploaded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getUploadedFiles'])->name('get-uploaded-files');
    Route::get('get-embedded-files' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'getEmbeddedFiles'])->name('get-embedded-files');
    Route::post('embed-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'embedFile'])->name('embed-file');
    Route::post('update-embed-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateEmbeddedFile'])->name('update-embed-file');
    Route::post('updated-uploaded-file/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'updateUploadedFile'])->name('updated-uploaded-file');
    Route::post('upload-file' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'uploadFile'])->name('upload-file');
    Route::delete('delete-uploaded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteUploadedFiles'])->name('delete-uploaded-files');
    Route::delete('delete-embedded-files/{mediaLibrary}' , [\Modules\MediaLibrary\Http\Controllers\MediaLibraryController::class , 'deleteEmbeddedFiles'])->name('delete-embedded-files');

});
