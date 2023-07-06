
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


Route::middleware(['create_permissions','auth:sanctum' , 'dashboard'])->group(function () {
        // lms dashboard
        Route::apiResource('courses', \Modules\Course\Http\Controllers\CourseController::class);
        Route::apiResource('courses-levels', \Modules\Course\Http\Controllers\CoursesLevelsController::class);
        Route::apiResource('courses-categories', \Modules\Course\Http\Controllers\CoursesCategoriesController::class);
        Route::patch('update-course-logo/{course_id}', [\Modules\Course\Http\Controllers\CourseController::class, 'updateCourseLogo'])->name('update-course-logo');

        //chapters
        Route::get('get-course-material/{course_id}', [\Modules\Course\Http\Controllers\ChaptersController::class, 'getCourseMaterial'])->name('get-course-material');
        Route::apiResource('chapters', \Modules\Course\Http\Controllers\ChaptersController::class);

        // lectures
        Route::apiResource('lectures', \Modules\Course\Http\Controllers\LecturesController::class);

        // lecture content
        Route::post('lecture-content/add-video-from-library', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVideoFromVideoLibrary'])->name('lecture-content.add-video-from-library');
        Route::post('lecture-content/upload-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'uploadVideoFromDevice'])->name('lecture-content.upload-video');
        Route::post('lecture-content/embed-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'embedVideo'])->name('lecture-content.embed-video');
        Route::post('lecture-content/add-article', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addArticleToLectureContent'])->name('lecture-content.add-article');
        Route::post('lecture-content/add-voice', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVoiceToLectureContent'])->name('lecture-content.add-voice');
        Route::post('lecture-content/add-document', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addDocumentToLectureContent'])->name('lecture-content.add-document');
        Route::delete('lecture-content/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class, 'destroy'])->name('lecture-content.delete');

        Route::post('lecture-content/update-document/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateDocumentToLectureContent'])->name('lecture-content.update-document');
        Route::post('lecture-content/update-article/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateArticleToLectureContent'])->name('lecture-content.update-article');
        Route::post('lecture-content/update-voice/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVoiceLectureContent'])->name('lecture-content.update-voice');
        Route::post('lecture-content/update-video/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVideoLectureContent'])->name('lecture-content.update-video');

});


Route::as('lms.')->prefix('lms')->middleware([
    'create_permissions', 'api', 'check_language', 'json.response' , 'lms' ,
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware('auth:sanctum')->group(function (){


        // lms dashboard
        Route::apiResource('courses', \Modules\Course\Http\Controllers\CourseController::class);
        Route::apiResource('courses-levels', \Modules\Course\Http\Controllers\CoursesLevelsController::class);
        Route::apiResource('courses-categories', \Modules\Course\Http\Controllers\CoursesCategoriesController::class);
        Route::patch('update-course-logo/{course_id}', [\Modules\Course\Http\Controllers\CourseController::class, 'updateCourseLogo'])->name('update-course-logo');

        //chapters
        Route::get('get-course-material/{course_id}', [\Modules\Course\Http\Controllers\ChaptersController::class, 'getCourseMaterial'])->name('get-course-material');
        Route::apiResource('chapters', \Modules\Course\Http\Controllers\ChaptersController::class);

        // lectures
        Route::apiResource('lectures', \Modules\Course\Http\Controllers\LecturesController::class);

        // lecture content
        Route::post('lecture-content/add-video-from-library', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVideoFromVideoLibrary'])->name('lecture-content.add-video-from-library');
        Route::post('lecture-content/upload-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'uploadVideoFromDevice'])->name('lecture-content.upload-video');
        Route::post('lecture-content/embed-video', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'embedVideo'])->name('lecture-content.embed-video');
        Route::post('lecture-content/add-article', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addArticleToLectureContent'])->name('lecture-content.add-article');
        Route::post('lecture-content/add-voice', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addVoiceToLectureContent'])->name('lecture-content.add-voice');
        Route::post('lecture-content/add-document', [\Modules\Course\Http\Controllers\LectureContentsController::class, 'addDocumentToLectureContent'])->name('lecture-content.add-document');
        Route::delete('lecture-content/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class, 'destroy'])->name('lecture-content.delete');

        Route::post('lecture-content/update-document/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateDocumentToLectureContent'])->name('lecture-content.update-document');
        Route::post('lecture-content/update-article/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateArticleToLectureContent'])->name('lecture-content.update-article');
        Route::post('lecture-content/update-voice/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVoiceLectureContent'])->name('lecture-content.update-voice');
        Route::post('lecture-content/update-video/{lecture_content}' , [\Modules\Course\Http\Controllers\LectureContentsController::class , 'updateVideoLectureContent'])->name('lecture-content.update-video');
        // landing page
    });


});
