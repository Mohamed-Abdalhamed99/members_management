<?php

use Illuminate\Http\Request;

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
    Route::apiResource('courses-levels', \Modules\Course\Http\Controllers\CoursesLevelsController::class);
    Route::apiResource('courses-categories', \Modules\Course\Http\Controllers\CoursesCategoriesController::class);
    Route::apiResource('courses', \Modules\Course\Http\Controllers\CourseController::class);
    Route::patch('update-course-logo/{course_id}' ,[\Modules\Course\Http\Controllers\CourseController::class , 'updateCourseLogo'] );
});


Route::as('lms.')->prefix('lms')->middleware([
    'api', 'check_language' , 'json.response',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::middleware('auth:sanctum')->get('/course', function (Request $request) {
        return $request->user();
    });
});
