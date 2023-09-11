<?php

namespace Modules\Exam\Http\Controllers;

use App\Models\Exam;
use App\Models\QTypeChoices;
use App\Models\QTypeFillBlank;
use App\Models\Question;
use App\Models\QuestionType;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Exam\Http\Requests\CreateQuestionChoiceRequest;
use Modules\Exam\Http\Requests\CreateQuestionFillblankRequest;
use Modules\Exam\Http\Requests\CreateQuestionFreeTextRequest;
use Modules\Exam\Http\Requests\CreateQuestionMatchingRequest;
use Modules\Exam\Http\Requests\CreateQuestionTrueFalseRequest;
use Modules\Exam\Http\Requests\QuestionRequest;
use Modules\Exam\Transformers\Teacher\QuestionsResource;
use Modules\Exam\Transformers\Teacher\ShowQuestionResource;

class QuestionsController extends Controller
{
    use HttpResponse;

    /**
     * get all questions types
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function getQuestionsTypes()
    {
        $types = collect(QuestionType::get())->transform(function($item){
            return [
                'id' => $item->id,
                'type' => $item->type,
            ];
        });

        return $this->respond( $types);
    }

     /**
     * get all exam's questions
     *
     * @param Exam
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function getQuestions(Exam $exam)
    {
        return $this->respond(QuestionsResource::collection($exam->questions));
    }

    public function show(Question $question){
        return new ShowQuestionResource($question);
    }


    /**
     * create new question
     *
     * @param $request contain question data
     * @return Question $q
     */
    public function createQuestion($request)
    {
        $q = [
            'exam_id' => $request->exam_id,
            'question_type_id' => $request->question_type_id,
            'title' => $request->title,
            'grade' => $request->grade
        ];

        $q = Question::create($q);

        return $q;
    }

    /**
     * create question with type choices
     *
     * @param Modules\Exam\Http\Requests\CreateQuestionChoiceRequest
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function createQuestionChoice(CreateQuestionChoiceRequest $request)
    {
        $q = $this->createQuestion($request);

        $q_choices = [
            'choice_a' => $request->choice_a,
            'choice_b' => $request->choice_b,
            'choice_c' => $request->choice_c,
            'choice_d' => $request->choice_d,
            'answer' => $request->answer,
        ];


        $q->choices()->create($q_choices);

        return $this->responseCreated($q , 'تمت إضافة السؤال بنجاح');
    }

    /**
     * create fill blank question
     *
     * @param Modules\Exam\Http\Requests\CreateQuestionFillblankRequest
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function createQuestionFillblank(CreateQuestionFillblankRequest $request)
    {
        $q = $this->createQuestion($request);

        foreach($request->blanks as $blank){
            $q->fillblank()->create([
                'blank_name' => $blank['blank_name'],
                'answer' => $blank['answer']
           ]);
        }

        return $this->responseCreated($q , 'تمت إضافة السؤال بنجاح');
    }

    /**
     * create true or false question
     *
     * @param Modules\Exam\Http\Requests\CreateQuestionTrueFalseRequest
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function createQuestionTruefalse(CreateQuestionTrueFalseRequest $request)
    {
        $q = $this->createQuestion($request);
        $q->tureOrFalse()->create(['answer' => $request->answer]);
        return $this->responseCreated($q , 'تمت إضافة السؤال بنجاح');
    }

    /**
     * create free text question
     *
     * @param Modules\Exam\Http\Requests\CreateQuestionFreeTextRequest
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function createQuestionFreetext(CreateQuestionFreeTextRequest $request)
    {
        $q = $this->createQuestion($request);
        $q->freetext()->create(['words' => $request->words]);
        return $this->responseCreated($q , 'تمت إضافة السؤال بنجاح');
    }

    /**
     * create matching question
     *
     * @param Modules\Exam\Http\Requests\CreateQuestionMatchingRequest
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function createQuestionMatching(CreateQuestionMatchingRequest $request)
    {
        $q = $this->createQuestion($request);
        foreach($request->matchings as $matching){
            $q->matching()->create([
                'option' => $matching['option'],
                'match' => $matching['match']
           ]);
        }
        return $this->responseCreated($q , 'تمت إضافة السؤال بنجاح');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return $this->responseOk( 'تمت حذف السؤال بنجاح');
    }

    //  /**
    //  * update question info
    //  *
    //  * @param $request contain question data
    //  * @return Question $q
    //  */
    // public function updateQuestion($request , $q)
    // {
    //     $q_data = [
    //         'exam_id' => $request->exam_id,
    //         'question_type_id' => $request->question_type_id,
    //         'title' => $request->title,
    //         'grade' => $request->grade
    //     ];

    //     $q->update($q_data);

    //     return $q;
    // }

    // /**
    //  * update question with type choices
    //  *
    //  * @param Modules\Exam\Http\Requests\CreateQuestionChoiceRequest
    //  * @return Symfony\Component\HttpFoundation\Response
    //  */
    // public function updateQuestionChoice(CreateQuestionChoiceRequest $request , Question $question)
    // {
    //     $q = $this->updateQuestion($request , $question);

    //     $q_choices = [
    //         'choice_a' => $request->choice_a,
    //         'choice_b' => $request->choice_b,
    //         'choice_c' => $request->choice_c,
    //         'choice_d' => $request->choice_d,
    //         'answer' => $request->answer,
    //     ];

    //     $q->choices()->update($q_choices);

    //     return $this->responseOk('تم تعديل السؤال بنجاح');
    // }

    // /**
    //  * update fill blank question
    //  *
    //  * @param Modules\Exam\Http\Requests\CreateQuestionFillblankRequest
    //  * @return Symfony\Component\HttpFoundation\Response
    //  */
    // public function updateQuestionFillblank(CreateQuestionFillblankRequest $request , Question $question)
    // {
    //     $q = $this->updateQuestion($request , $question);

    //     foreach($request->blanks as $blank){
    //         $q->fillblank()->update([
    //             'blank_name' => $blank['blank_name'],
    //             'answer' => $blank['answer']
    //        ]);
    //     }

    //     return $this->responseOk('تم تعديل السؤال بنجاح');
    // }

    // /**
    //  * update true or false question
    //  *
    //  * @param Modules\Exam\Http\Requests\CreateQuestionTrueFalseRequest
    //  * @return Symfony\Component\HttpFoundation\Response
    //  */
    // public function updateQuestionTruefalse(CreateQuestionTrueFalseRequest $request , Question $question)
    // {
    //     $q = $this->createQuestion($request , $question);
    //     $q->tureOrFalse()->update(['answer' => $request->answer]);
    //     return $this->responseOk('تم تعديل السؤال بنجاح');
    // }

    // /**
    //  * update free text question
    //  *
    //  * @param Modules\Exam\Http\Requests\CreateQuestionFreeTextRequest
    //  * @return Symfony\Component\HttpFoundation\Response
    //  */
    // public function updateQuestionFreetext(CreateQuestionFreeTextRequest $request , Question $question)
    // {
    //     $q = $this->createQuestion($request , $question);
    //     $q->freetext()->update(['words' => $request->words]);
    //     return $this->responseOk('تم تعديل السؤال بنجاح');
    // }

    // /**
    //  * update matching question
    //  *
    //  * @param Modules\Exam\Http\Requests\CreateQuestionMatchingRequest
    //  * @return Symfony\Component\HttpFoundation\Response
    //  */
    // public function updateQuestionMatching(CreateQuestionMatchingRequest $request , Question $question)
    // {
    //     $q = $this->updateQuestion($request , $question);
    //     foreach($request->matchings as $matching){
    //         $q->matching()->update([
    //             'option' => $matching['option'],
    //             'match' => $matching['match']
    //        ]);
    //     }
    //     return $this->responseOk('تم تعديل السؤال بنجاح');
    // }

}

