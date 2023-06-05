<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class LectureContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // content type
    public const VIDEO = 1;
    public const ARTICLE = 2;
    public const VOICE = 3;
    public const DOCUMENT = 4;

    protected $guarded = [];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_id', 'id');
    }

    public function video()
    {
        return $this->belongsTo(VideoLibrary::class, 'video_id', 'id');
    }

    public function getTypeNameAttribute()
    {
        if ($this->type == self::VIDEO) {
            return 'فيديو';
        } elseif ($this->type == self::ARTICLE) {
            return 'مقالة';
        }elseif ($this->type == self::VOICE) {
            return 'تسجيل صوتي';
        }elseif ($this->type == self::DOCUMENT) {
            return 'ملف';
        }
    }
}
