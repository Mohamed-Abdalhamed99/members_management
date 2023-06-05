
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


Route::middleware(['auth:sanctum'])->group(function () {

    // lms dashboard
    Route::apiResource('courses-levels', \Modules\Course\Http\Controllers\CoursesLevelsController::class);
    Route::apiResource('courses-categories', \Modules\Course\Http\Controllers\CoursesCategoriesController::class);
    Route::apiResource('courses', \Modules\Course\Http\Controllers\CourseController::class);
    Route::patch('update-course-logo/{course_id}', [\Modules\Course\Http\Controllers\CourseController::class, 'updateCourseLogo']);

    //chapters
    Route::get('get-course-material/{course_id}', [\Modules\Course\Http\Controllers\ChaptersController::class, 'getCourseMaterial']);
    Route::apiResource('chapters', \Modules\Course\Http\Controllers\ChaptersController::class);

    // lectures
    Route::apiResource('lectures', \Modules\Course\Http\Controllers\LecturesController::class);

    // lecture content
    Route::post('lecture-content/add-video-from-library', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVideoFromVideoLibrary']);
    Route::post('lecture-content/upload-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'uploadVideoFromDevice']);
    Route::post('lecture-content/embed-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'embedVideo']);
    Route::post('lecture-content/add-article', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addArticleToLectureContent']);
    Route::post('lecture-content/add-voice', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVoiceToLectureContent']);
    Route::post('lecture-content/add-document', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addDocumentToLectureContent']);
    Route::delete('lecture-content/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class, 'destroy']);

    Route::post('lecture-content/update-document/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateDocumentToLectureContent']);
    Route::post('lecture-content/update-article/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateArticleToLectureContent']);
    Route::post('lecture-content/update-voice/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVoiceLectureContent']);
    Route::post('lecture-content/update-video/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVideoLectureContent']);
    // landing page


});


Route::as('lms.')->prefix('lms')->middleware([
    'api', 'check_language', 'json.response' ,
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware('auth:sanctum')->group(function (){


        // lms dashboard
        Route::apiResource('courses', \Modules\Course\Http\Controllers\CourseController::class);
        Route::apiResource('courses-levels', \Modules\Course\Http\Controllers\CoursesLevelsController::class);
        Route::apiResource('courses-categories', \Modules\Course\Http\Controllers\CoursesCategoriesController::class);
        Route::patch('update-course-logo/{course_id}', [\Modules\Course\Http\Controllers\CourseController::class, 'updateCourseLogo']);

        //chapters
        Route::get('get-course-material/{course_id}', [\Modules\Course\Http\Controllers\ChaptersController::class, 'getCourseMaterial']);
        Route::apiResource('chapters', \Modules\Course\Http\Controllers\ChaptersController::class);

        // lectures
        Route::apiResource('lectures', \Modules\Course\Http\Controllers\LecturesController::class);

        // lecture content
        Route::post('lecture-content/add-video-from-library', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVideoFromVideoLibrary']);
        Route::post('lecture-content/upload-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'uploadVideoFromDevice']);
        Route::post('lecture-content/embed-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'embedVideo']);
        Route::post('lecture-content/add-article', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addArticleToLectureContent']);
        Route::post('lecture-content/add-voice', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVoiceToLectureContent']);
        Route::post('lecture-content/add-document', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addDocumentToLectureContent']);
        Route::delete('lecture-content/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class, 'destroy']);

        Route::post('lecture-content/update-document/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateDocumentToLectureContent']);
        Route::post('lecture-content/update-article/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateArticleToLectureContent']);
        Route::post('lecture-content/update-voice/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVoiceLectureContent']);
        Route::post('lecture-content/update-video/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVideoLectureContent']);
        // landing page
    });


});
