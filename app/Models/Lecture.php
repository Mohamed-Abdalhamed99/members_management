<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    //complete rules
    public const MARK_AS_LEARNED_CHECKBOX = 1;
    public const PASSING_QUIZE = 2;
    public const COMPLETE_VIDEO_PERCENTAGE = 3;

    protected $guarded = [];

    public function lecture()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function lecture_contents()
    {
        return $this->hasMany(LectureContent::class, 'lecture_id', 'id');
    }

    public function getCompleteRuleNameAttribute()
    {
        if ($this->completed_rule == self::MARK_AS_LEARNED_CHECKBOX) {
            return 'وضع علامة علي انهاء الدرس';
        } elseif ($this->completed_rule == self::PASSING_QUIZE) {
            return 'الانتهاء من الاختبار';
        } elseif ($this->completed_rule == self::COMPLETE_VIDEO_PERCENTAGE) {
            return 'الانتهاء من مشاهدة الدرس';
        }
    }
}
