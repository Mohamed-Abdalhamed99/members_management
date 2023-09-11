<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QTypeFreeText extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "q_type_free_text";
}
