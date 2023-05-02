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
}
