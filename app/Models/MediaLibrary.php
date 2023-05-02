<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaLibrary extends Model
{
    use HasFactory;

    // addition methods
    public const UPLOADED = 'upload';
    public const EMBED  = 'embed';

    protected $table = 'media_library';

    protected $guarded = [];
}
