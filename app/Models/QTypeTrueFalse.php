<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QTypeTrueFalse extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "q_type_true_false";
}
