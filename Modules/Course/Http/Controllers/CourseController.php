<?php

namespace Modules\Course\Http\Controllers;

use App\Models\Course;
use App\Models\MediaLibrary;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CreateCourseRequest;
use Modules\Course\Http\Requests\CreateCoursesCategoriesRequest;
use Modules\Course\Http\Requests\UpdateCourseLogoRequest;
use Modules\Course\Http\Requests\UpdateCourseRequest;
use Modules\Course\Http\Requests\UpdateCoursesCategoriesRequest;
use Modules\Course\Transformers\ChapterResource;
use Modules\Course\Transformers\CourseResource;
use Modules\Course\Transformers\CoursesResource;
use Modules\Course\Transformers\ShowCourseResource;
use Spatie\QueryBuilder\QueryBuilder;

class CourseController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $courses = QueryBuilder::for(Course::class)
            ->defaultSort('-created_at')
            ->allowedSorts(['name', 'instructor_name', 'price', 'created_at', 'is_publish'])
            ->allowedFilters(['name', 'instructor_name', 'price', 'is_publish'])
            ->paginate(\request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(CoursesResource::collection($courses)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCourseRequest $request)
    {
        $course = Course::create($request->except(['instructor_avatar', 'course_logo', 'course_logo_addition_method', 'instructor_avatar_addition_method', 'media_library_id']));

        if ($request->course_logo_addition_method == MediaLibrary::UPLOADED) {
            $filename = md5($request->file('course_logo')->getClientOriginalName()) . '.' . $request->file('course_logo')->getClientOriginalExtension();
            $course->addMediaFromRequest('course_logo')
                ->usingFileName($filename)
                ->toMediaCollection('courses_logo');
        } elseif ($request->course_logo_addition_method == MediaLibrary::EMBED) {

            $file = MediaLibrary::findOrFail($request->media_library_id);

            if ($file->addition_method == MediaLibrary::UPLOADED) {
                $course->addMedia($file->path)
                    ->usingFileName($file->file_name)
                    ->preservingOriginal()
                    ->toMediaCollection('courses_logo');
            } elseif ($file->addition_method == MediaLibrary::EMBED) {
                $course->addMediaFromUrl($file->path)
                    ->toMediaCollection('courses_logo');
            }

        }

        if ($request->hasFile('instructor_avatar')) {
            $filename = md5($request->file('instructor_avatar')->getClientOriginalName()) . '.' . $request->file('instructor_avatar')->getClientOriginalExtension();
            $course->addMediaFromRequest('instructor_avatar')
                ->usingFileName($filename)
                ->toMediaCollection('instructor_avatar');
        }

        return $this->responseCreated($course, 'تم إضافة دورة جديد');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Course $course)
    {
        $data['course'] = new ShowCourseResource($course);
        $data['chapters'] = ChapterResource::collection($course->chapters);
        return $this->respond($data);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->except(['instructor_avatar', 'course_logo', 'course_logo_addition_method', 'instructor_avatar_addition_method', 'media_library_id']));


        if ($request->hasFile('instructor_avatar')) {
            $course->getFirstMedia('instructor_avatar')->delete();
            $filename = md5($request->file('instructor_avatar')->getClientOriginalName()) . '.' . $request->file('instructor_avatar')->getClientOriginalExtension();
            $course->addMediaFromRequest('instructor_avatar')
                ->usingFileName($filename)
                ->toMediaCollection('instructor_avatar');
        }

        return $this->responseOk('تم تعديل دورة ');
    }

    public function updateCourseLogo(UpdateCourseLogoRequest $request, $course_id)
    {
        $course = Course::findOrFail($course_id);

        $course->getFirstMedia('courses_logo')->delete();

        if ($request->course_logo_addition_method == MediaLibrary::UPLOADED) {
            $filename = md5($request->file('course_logo')->getClientOriginalName()) . '.' . $request->file('course_logo')->getClientOriginalExtension();
            $course->addMediaFromRequest('course_logo')
                ->usingFileName($filename)
                ->toMediaCollection('courses_logo');
        } elseif ($request->course_logo_addition_method == MediaLibrary::EMBED) {

            $file = MediaLibrary::findOrFail($request->media_library_id);

            if ($file->addition_method == MediaLibrary::UPLOADED) {
                $course->addMedia($file->path)
                    ->usingFileName($file->file_name)
                    ->preservingOriginal()
                    ->toMediaCollection('courses_logo');
            } elseif ($file->addition_method == MediaLibrary::EMBED) {
                $course->addMediaFromUrl($file->path)
                    ->toMediaCollection('courses_logo');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }
}
