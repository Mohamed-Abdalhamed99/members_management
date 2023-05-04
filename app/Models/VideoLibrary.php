<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLibrary extends Model
{
    use HasFactory;

    protected $table = 'video_library';

    protected $guarded = [];

    // addition methods
    public const UPLOADED = 'upload';
    public const EMBED = 'embed';

    //third party
    public const YOUTUBE = 'youtube';
    public const VIMEO = 'vimeo';


    public function getUrlAttribute()
    {
        if ($this->addition_method == self::EMBED) {
            return $this->path;
        } elseif ($this->addition_method == self::UPLOADED) {
            return asset($this->path);
        }
    }
}
