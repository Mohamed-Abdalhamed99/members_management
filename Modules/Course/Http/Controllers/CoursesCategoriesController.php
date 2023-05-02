<?php

namespace Modules\Course\Http\Controllers;

use App\Models\CoursesCategory;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CreateCoursesCategoriesRequest;
use Modules\Course\Http\Requests\UpdateCoursesCategoriesRequest;
use Modules\Course\Transformers\CoursesCategoryResource;
use Modules\Course\Transformers\CoursesResource;
use Spatie\QueryBuilder\QueryBuilder;

class CoursesCategoriesController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coursesCategories = QueryBuilder::for(CoursesCategory::class)
            ->defaultSort('-created_at')
            ->allowedSorts('name')
            ->allowedFilters(['name' , 'description'])
            ->paginate(\request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(CoursesCategoryResource::collection($coursesCategories)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCoursesCategoriesRequest $request)
    {
        $coursesCategory = CoursesCategory::create($request->validated());
        return $this->responseCreated($coursesCategory , 'تم إضافة مستوي جديد');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(CoursesCategory $coursesCategory)
    {
        $data['course_category'] = new CoursesCategoryResource($coursesCategory);
        $data['courses'] = CoursesResource::collection($coursesCategory->courses);
        return $this->respond($data);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCoursesCategoriesRequest $request, CoursesCategory $coursesCategory)
    {
        $coursesCategory = $coursesCategory->update($request->validated());
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(CoursesCategory $coursesCategory)
    {
        $coursesCategory->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }
}
