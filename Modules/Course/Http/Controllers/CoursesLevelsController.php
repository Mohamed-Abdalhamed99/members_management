<?php

namespace Modules\Course\Http\Controllers;

use App\Models\CoursesLevel;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CreateCoursesLevelRequest;
use Modules\Course\Http\Requests\UpdateCoursesLevelRequest;
use Modules\Course\Transformers\CoursesLevelResource;
use Spatie\QueryBuilder\QueryBuilder;

class CoursesLevelsController extends Controller
{

    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coursesLevels = QueryBuilder::for(CoursesLevel::class)
            ->defaultSort('-created_at')
            ->allowedSorts('name')
            ->allowedFilters('name')
            ->paginate(\request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(CoursesLevelResource::collection($coursesLevels)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCoursesLevelRequest $request)
    {
        $coursesLevel = CoursesLevel::create($request->validated());
        return $this->responseCreated($coursesLevel , 'تم إضافة مستوي جديد');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(CoursesLevel $coursesLevel)
    {
        return $this->respond(new CoursesLevelResource($coursesLevel));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCoursesLevelRequest $request, CoursesLevel $coursesLevel)
    {
        $coursesLevel = $coursesLevel->update($request->validated());
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(CoursesLevel $coursesLevel)
    {
        $coursesLevel->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }
}
