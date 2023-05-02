<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses(){
        return $this->hasMany(Course::class , 'course_category_id' , 'id');
    }

}
