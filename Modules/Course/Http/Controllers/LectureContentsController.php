<?php

namespace Modules\Course\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureContent;
use App\Models\VideoLibrary;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\AddDocumentLectureContentRequest;
use Modules\Course\Http\Requests\AddLectureContentArticleRequest;
use Modules\Course\Http\Requests\AddVideoFromVideoLibraryRequest;
use Modules\Course\Http\Requests\AddVoiceLectureContentRequest;
use Modules\Course\Http\Requests\CreateLectureContentRequest;
use Modules\Course\Http\Requests\EmbedVideoRequest;
use Modules\Course\Http\Requests\UpdateDocumentLectureContentRequest;
use Modules\Course\Http\Requests\UpdateVideoLectureContentRequest;
use Modules\Course\Http\Requests\UpdateVoiceLectureContentRequest;
use Modules\Course\Http\Requests\UploadVideoFromDeviceRequest;

class LectureContentsController extends Controller
{

    use HttpResponse;




    public function updateVideoLectureContent(UpdateVideoLectureContentRequest $request, LectureContent $lectureContent)
    {
        // check media type
        if ($lectureContent->type != LectureContent::VIDEO) {
            return $this->responseUnProcess('المحتوي المطلوب تعديله يجب ان يكون من نوع فيديو');
        }

        // update lecture content
        $lectureContent->update([
            'title' => $request->title,
        ]);

        // update video
        if ($request->addition_method == VideoLibrary::UPLOADED) {
            // check if has file
            if($request->has('video')){
                // update video
            }
        } elseif ($request->addition_method == VideoLibrary::EMBED) {
                // delete old video_library
            // create new video library
            // relate new video library to lecture content

        }
    }

    public function addVideoFromVideoLibrary(AddVideoFromVideoLibraryRequest $request)
    {
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'video_id' => $request->video_id,
            'title' => $request->title,
            'type' => LectureContent::VIDEO,
            'sort' => $sort_number
        ]);

        return $this->responseOk('تم إضافة الفيديو بنجاح');
    }

    public function uploadVideoFromDevice(UploadVideoFromDeviceRequest $request)
    {
        // create video_libray
        // create lecture content
        $video = $request->file('video');
        $video_name = md5($request->title . time()) . '.' . $video->getClientOriginalExtension();
        $size = $video->getSize(); // in bytes
        $video->move('video_library', $video_name);

        $getID3 = new \getID3;
        $time_duration = $getID3->analyze(public_path('video_library/' . $video_name))['playtime_seconds']; //time duration in seconds
        $time_duration = round($time_duration, 2);

        // video library
        $video = VideoLibrary::create([
            'name' => $video_name,
            'addition_method' => VideoLibrary::UPLOADED,
            'path' => 'video_library/' . $video_name,
            'time_duration' => $time_duration,
            'size' => $size,
        ]);

        // make sort number
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        // create lecture content
        LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'video_id' => $video->id,
            'title' => $request->title,
            'type' => LectureContent::VIDEO,
            'sort' => $sort_number
        ]);
        return $this->responseOk('تم إضافة الفيديو بنجاح');
    }

    public function embedVideo(EmbedVideoRequest $request)
    {
        // create video_library embed type
        $video_library = VideoLibrary::create([
            'name' => md5($request->title . time()),
            'addition_method' => VideoLibrary::EMBED,
            'path' => $request->path,
            'third_party_name' => $request->third_party_name,
            'time_duration' => ($request->hours * 60 * 60) + ($request->minutes * 60) + $request->seconds
        ]);

        // make sort number
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        // create lecture_content
        LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'video_id' => $video_library->id,
            'title' => $request->title,
            'type' => LectureContent::VIDEO,
            'sort' => $sort_number
        ]);
        return $this->responseOk('تم إضافة الفيديو بنجاح');
    }

    public function addArticleToLectureContent(AddLectureContentArticleRequest $request)
    {
        // make sort number
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'title' => $request->title,
            'article' => $request->article,
            'sort' => $sort_number,
            'type' => LectureContent::ARTICLE,
        ]);

        return $this->responseOk('تم إضافة المقالة بنجاح');
    }

    public function addVoiceToLectureContent(AddVoiceLectureContentRequest $request)
    {
        // make sort number
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        $content = LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'title' => $request->title,
            'sort' => $sort_number,
            'type' => LectureContent::VOICE,
        ]);

        $content->addMediaFromRequest('voice')
            ->usingFileName($request->title . '_' . $request->file('voice')->getClientOriginalName() . '.' . $request->file('voice')->getClientOriginalExtension())
            ->toMediaCollection('lec_content');

        return $this->responseOk('تم إضافة التسجيل بنجاح');
    }

    public function addDocumentToLectureContent(AddDocumentLectureContentRequest $request)
    {
        // make sort number
        $sort_number = Lecture::findOrFail($request->lecture_id)->lecture_contents()->count() + 1;

        $content = LectureContent::create([
            'lecture_id' => $request->lecture_id,
            'title' => $request->title,
            'sort' => $sort_number,
            'type' => LectureContent::DOCUMENT,
        ]);

        $content->addMediaFromRequest('document')
            ->usingFileName($request->title . '_' . $request->file('document')->getClientOriginalName() . '.' . $request->file('document')->getClientOriginalExtension())
            ->toMediaCollection('lec_content');

        return $this->responseOk('تم إضافة الملف بنجاح');
    }







    public function updateArticleToLectureContent(AddLectureContentArticleRequest $request, LectureContent $lectureContent)
    {
        if ($lectureContent->type != LectureContent::ARTICLE) {
            return $this->responseUnProcess('المحتوي المطلوب تعديله يجب ان يكون من نوع مقالة');
        }

        $lectureContent->update([
            'lecture_id' => $request->lecture_id,
            'title' => $request->title,
            'article' => $request->article,
        ]);

        return $this->responseOk('تم تعديل المحتوي بنجاح');
    }

    public function updateVoiceLectureContent(UpdateVoiceLectureContentRequest $request, LectureContent $lectureContent)
    {
        if ($lectureContent->type != LectureContent::VOICE) {
            return $this->responseUnProcess('المحتوي المطلوب تعديله يجب ان يكون من نوع تسجيل صوتي');
        }

        $lectureContent->update([
            'title' => $request->title,
        ]);

        if ($request->has('voice')) {
            $lectureContent->getFirstMedia('lec_content')->delete();
            $lectureContent->addMediaFromRequest('voice')
                ->usingFileName($request->title . '_' . $request->file('voice')->getClientOriginalName() . '.' . $request->file('voice')->getClientOriginalExtension())
                ->toMediaCollection('lec_content');
        }

        return $this->responseOk('تم تعديل المحتوي بنجاح');
    }

    public function updateDocumentToLectureContent(UpdateDocumentLectureContentRequest $request, LectureContent $lectureContent)
    {

        if ($lectureContent->type != LectureContent::DOCUMENT) {
            return $this->responseUnProcess('المحتوي المطلوب تعديله يجب ان يكون من نوع ملف');
        }

        $lectureContent->update([
            'title' => $request->title,
        ]);

        if ($request->has('document')) {
            $lectureContent->getFirstMedia('lec_content')->delete();
            $lectureContent->addMediaFromRequest('document')
                ->usingFileName($request->title . '_' . $request->file('document')->getClientOriginalName() . '.' . $request->file('document')->getClientOriginalExtension())
                ->toMediaCollection('lec_content');
        }

        return $this->responseOk('تم تعديل المحتوي بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(LectureContent $lectureContent)
    {
        if ($lectureContent->type == LectureContent::VIDEO) {
            $video = $lectureContent->video;
            if ($video->addition_method == VideoLibrary::UPLOADED) {
                unlink($video->path);
            }
        }
        $lectureContent->delete();
        return $this->responseOk('تم حذف المحتوي بنجاح');
    }
}
