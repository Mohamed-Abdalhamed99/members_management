<?php

namespace Modules\Course\Http\Controllers;

use App\Models\Chapter;
use App\Models\Lecture;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CreateLectureRequest;
use Modules\Course\Http\Requests\UpdateLectureRequest;
use Modules\Course\Transformers\LectureResource;

class LecturesController extends Controller
{

    use HttpResponse;

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateLectureRequest $request)
    {
        $chapter = Chapter::findOrFail($request->chapter_id);
        $sort_order = $chapter->lectures()->count() + 1;
        $chapter->lectures()->create([
            'name' => $request->name,
            'chapter_id' => $request->chapter_id,
            'completed_rule' => $request->completed_rule,
            'sort' => $sort_order
        ]);
        return $this->responseOk('تم إضافة المحتوي بنجاح');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Lecture $lecture)
    {
        return $this->respond(new LectureResource($lecture));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        $lecture->update($request->validated());
        return $this->responseOk('تم النعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }
}
