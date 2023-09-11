<?php

namespace Modules\Exam\Http\Controllers;

use App\Models\Question;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateQuestionsController extends Controller
{
    use HttpResponse;

    protected $q_rules = [
        'question_type_id' => ['required' , 'numeric' , 'exists:question_types,id'],
        'title' => ['required' , 'string' , 'max:255'],
        'grade' => ['required' , 'numeric' ]
    ];


    public function updateQuestion(Request $request , Question $question)
    {
        // validate question data
        $validator = Validator::make($request->all() , $this->q_rules );
        if($validator->fails()){
            return $this->responseBadRequest($validator->errors());
        }

        // update question info
        $question->update([
            'title' => $request->title,
            'grade' => $request->grade
        ]);

        // update queston details
        if($request->question_type_id == 1){  // multi choice question
            // set rules
            $rules = [
                'choice_a' => ['required' , 'string' , 'max:255'],
                'choice_b' => ['required' , 'string' , 'max:255'],
                'choice_c' => ['required' , 'string' , 'max:255'],
                'choice_d' => ['required' , 'string' , 'max:255'],
                'answer' => ['required' , 'string' , 'max:255']
            ];

            // validate choice question details
            $validator = Validator::make($request->all() , $rules );
            if($validator->fails()){
                return $this->responseBadRequest($validator->errors());
            }

            // update question choices
            $question->choices()->update([
                'choice_a' => $request->choice_a ,
                'choice_b' => $request->choice_b ,
                'choice_c' => $request->choice_c ,
                'choice_d' => $request->choice_d ,
                'answer' => $request->answer
            ]);

        }elseif($request->question_type_id == 2){ // fillblank
            // set fill blank rule
            $rules = [
                "blanks" => ["required" , "array"]
            ];

            // validate fillblank data
            $validator = Validator::make($request->all() , $rules );
            if($validator->fails()){
                return $this->responseBadRequest($validator->errors());
            }

            // delete old the question's fill blank details
            $question->fillblank()->delete();

            foreach($request->blanks as $blank){
                // store the new fill blank data
                $question->fillblank()->create([
                    'blank_name' => $blank['blank_name'],
                    'answer' => $blank['answer']
               ]);
            }

        }elseif($request->question_type_id == 3){ // true and false
            $rules = [
                'answer' => ['required' , 'boolean']
            ];

            $validator = Validator::make($request->all() , $rules );
            if($validator->fails()){
                return $this->responseBadRequest($validator->errors());
            }

            $question->tureOrFalse()->update(['answer' => $request->answer]);

        }elseif($request->question_type_id == 4){ // free text
            $rules = [
                'words' => ['required' , 'numeric']
            ];

            $validator = Validator::make($request->all() , $rules );
            if($validator->fails()){
                return $this->responseBadRequest($validator->errors());
            }

            $question->freetext()->update(['words' => $request->words]);

        }elseif($request->question_type_id == 5){ // matching
            $rules = [
                'matchings' => ['required' , 'array']
            ];

            $validator = Validator::make($request->all() , $rules );
            if($validator->fails()){
                return $this->responseBadRequest($validator->errors());
            }

            $question->matching()->delete();

            foreach($request->matchings as $matching){
                $question->matching()->create([
                    'option' => $matching['option'],
                    'match' => $matching['match']
               ]);
            }

        }

        return $this->responseOk('تم التعديل بنجاح');
    }
}
