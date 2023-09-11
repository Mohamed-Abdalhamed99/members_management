<?php

namespace Modules\Exam\Http\Controllers;

use App\Models\Exam;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Http\Requests\ExamRequest;
use Modules\Exam\Transformers\Student\ExamResource;
use Modules\Exam\Transformers\Teacher\ShowExamResource;
use Modules\Exam\Transformers\Teacher\ExamsResource;
use Spatie\QueryBuilder\QueryBuilder;

class ExamController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $exams = QueryBuilder::for(Exam::class)
                ->defaultSort('-created_at')
                ->allowedSorts(['name', 'instructor', 'price', 'created_at', 'passing_score'])
                ->allowedFilters(['name', 'instructor', 'price', 'created_at', 'passing_score'])
                ->paginate(\request()->pages ?? 10)
                ->appends(request()->query());

        return $this->respond(ExamsResource::collection($exams)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ExamRequest $request)
    {
        $exam = Exam::create($request->validated());
        return $this->responseCreated($exam , 'تم إضافة الاختبار بنجاح');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Exam $exam)
    {
        return $this->respond(new ShowExamResource($exam));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->update($request->validated());
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }

    public function viewExamAsStudent(Exam $exam)
    {
        return new ExamResource($exam);
    }
}
