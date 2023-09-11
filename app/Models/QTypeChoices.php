<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QTypeChoices extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "q_type_choices";
}
