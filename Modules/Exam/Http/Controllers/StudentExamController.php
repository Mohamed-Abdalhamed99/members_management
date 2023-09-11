<?php

namespace Modules\Exam\Http\Controllers;

use App\Models\Exam;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StudentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getExam(Exam $exam)
    {
        return $exam;
    }
}
