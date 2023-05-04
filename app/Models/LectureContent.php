<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class LectureContent extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    // content type
    public const VIDEO = 1;
    public const PDF = 2;
    public const ARTICLE = 3;
    public const VOICE = 4;
    public const DOCUMENT = 5;

    protected $guarded = [];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class , 'lecture_id' , 'id');
    }
}
