<?php

use App\Models\Exam;
use App\Models\Tenant;
use Faker\Factory;
use Illuminate\Http\Request;
use Modules\Exam\Http\Controllers\ExamController;
use Modules\Exam\Http\Controllers\QuestionsController;
use Modules\Exam\Http\Controllers\StudentExamController;
use Modules\Exam\Http\Controllers\UpdateQuestionsController;
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

Route::middleware('auth:api')->get('/exam', function (Request $request) {
    return $request->user();
});


Route::get('get-student-exam/{exam}', [StudentExamController::class , 'getExam']);


Route::as('lms.')->prefix('lms')->middleware([
    'create_permissions', 'api', 'check_language', 'json.response' , 'lms' ,
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware('auth:sanctum')->group(function (){
        Route::apiResource('exams' , ExamController::class);
        Route::get('view-exam-as-student/{exam}' , [ ExamController::class , 'viewExamAsStudent']);
        Route::get('get-questions-type', [ QuestionsController::class , 'getQuestionsTypes']);
        Route::get('exam-questions/{exam}',[ QuestionsController::class , 'getQuestions']);
        Route::get('question/{question}',[ QuestionsController::class , 'show']);
        
        // create questions
        Route::post('create-question-choices' , [ QuestionsController::class , 'createQuestionChoice']);
        Route::post('create-question-fillblank' , [ QuestionsController::class , 'createQuestionFillblank']);
        Route::post('create-question-truefalse' , [ QuestionsController::class , 'createQuestionTruefalse']);
        Route::post('create-question-freetext' , [ QuestionsController::class , 'createQuestionFreetext']);
        Route::post('create-question-matching' , [ QuestionsController::class , 'createQuestionMatching']);

        // update questions
        Route::post('update-question/{question}' , [UpdateQuestionsController::class , 'updateQuestion']);
        Route::delete('delete-question/{question}'  , [ QuestionsController::class , 'destroy']);
    });


});

Route::get('test_demo', function(){
    return Tenant::find('demo')->run(function (){
        $faker = Factory::create();

        Exam::create([
            'name' => $faker->title,
                'description' => "<p>". $faker->paragraph() ."</p>",
                'instructor' => $faker->name(),
                'instructions' => "<p>". $faker->paragraph() ."</p>",
                'passing_score' => 100,
                'price' => 250
        ]);
    });
});
