<?php

namespace Modules\Course\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CreateChapterRequest;
use Modules\Course\Http\Requests\UpdateChapterRequest;
use Modules\Course\Transformers\ChapterResource;
use Modules\Course\Transformers\ShowCourseResource;

class ChaptersController extends Controller
{

    use HttpResponse;

    public function getCourseMaterial($course_id)
    {
        $course = Course::findOrFail($course_id);
        $data['chapters'] = ChapterResource::collection($course->chapters);
        return $this->respond($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateChapterRequest $request)
    {
        $course = Course::findOrFail($request->course_id);
        $sort_order = $course->chapters()->count() + 1;
        $course->chapters()->create(['name' => $request->name, 'sort' => $sort_order]);
        return $this->responseOk('تم إضافة المحتوي بنجاح');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        $chapter->update($request->validated());
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }

}
