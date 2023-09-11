<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exam(){
        return $this->belongsTo(Exam::class , 'exam_id');
    }

    /**
     * questions types relations
     */
    public function questionTypes()
    {
        return $this->belongsTo(QuestionType::class , 'question_type_id');
    }

    public function choices()
    {
        return $this->hasMany(QTypeChoices::class , 'question_id');
    }

    public function fillblank()
    {
        return $this->hasMany(QTypeFillBlank::class , 'question_id');
    }

    public function matching()
    {
        return $this->hasMany(QTypeMatching::class , 'question_id');
    }

    public function tureOrFalse()
    {
        return $this->hasMany(QTypeTrueFalse::class , 'question_id');
    }

    public function freetext()
    {
        return $this->hasMany(QTypeFreeText::class , 'question_id');
    }

    /**
     * get question details depends on question type
     */
    public function getQuestionDetails()
    {
        if($this->question_type_id == 1){
            return $this->choices;
        }elseif($this->question_type_id == 2){
            return $this->fillblank;
        }elseif($this->question_type_id == 3){
            return $this->tureOrFalse;
        }elseif($this->question_type_id == 4){
            return $this->freetext;
        }elseif($this->question_type_id == 5){
            return $this->matching;
        }
    }
}
