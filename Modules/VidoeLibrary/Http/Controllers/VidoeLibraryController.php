<?php

namespace Modules\VidoeLibrary\Http\Controllers;

use App\Models\VideoLibrary;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Transformers\CoursesResource;
use Modules\VidoeLibrary\Http\Requests\CreateVideoLibraryRequest;
use Modules\VidoeLibrary\Http\Requests\UpdateVideoLibraryRequest;
use Modules\VidoeLibrary\Transformers\VideoLibraryResource;
use Spatie\QueryBuilder\QueryBuilder;

class VidoeLibraryController extends Controller
{

    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $videos = QueryBuilder::for(VideoLibrary::class)
            ->allowedFilters('name')
            ->allowedSorts('name')
            ->defaultSort('-created_at')
            ->paginate(\request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(VideoLibraryResource::collection($videos)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateVideoLibraryRequest $request)
    {
        if ($request->addition_method == VideoLibrary::UPLOADED) {

            $video = $request->file('video');
            $video_name = $request->name . '.' . $video->getClientOriginalExtension();
            $size = $video->getSize(); // in bytes
            $video->move('video_library', $video_name);

            $getID3 = new \getID3;
            $time_duration = $getID3->analyze(public_path('video_library/' . $video_name))['playtime_seconds']; //time duration in seconds
            $time_duration = round($time_duration, 2);

            VideoLibrary::create([
                'name' => $request->name,
                'addition_method' => $request->addition_method,
                'path' => 'video_library/' . $video_name,
                'time_duration' => $time_duration,
                'size' => $size,
            ]);

        } elseif ($request->addition_method == VideoLibrary::EMBED) {
            VideoLibrary::create([
                'name' => $request->name,
                'addition_method' => $request->addition_method,
                'path' => $request->path,
                'third_party_name' => $request->third_party_name,
                'time_duration' => ($request->hours * 60 * 60) + ($request->minutes * 60) + $request->seconds
            ]);
        }

        return $this->responseOk('تم أضافة الفيديو الي المكتبة بنجاح');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(VideoLibrary $videoLibrary)
    {
        $video = new VideoLibraryResource($videoLibrary);
        return $this->respond($video);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateVideoLibraryRequest $request, VideoLibrary $video_library)
    {

        if ($request->addition_method == VideoLibrary::UPLOADED) {

            $video = $request->file('video');
            $video_name = $request->name . '.' . $video->getClientOriginalExtension();
            $size = $video->getSize(); // in bytes
            $video->move('video_library', $video_name);

            $getID3 = new \getID3;
            $time_duration = $getID3->analyze(public_path('video_library/' . $video_name))['playtime_seconds']; //time duration in seconds
            $time_duration = round($time_duration, 2);

            $video_library->update([
                'name' => $request->name,
                'addition_method' => $request->addition_method,
                'path' => 'video_library/' . $video_name,
                'time_duration' => $time_duration,
                'size' => $size,
                'third_party_name' => null,
            ]);

        } elseif ($request->addition_method == VideoLibrary::EMBED) {
            $video_library->update([
                'name' => $request->name,
                'addition_method' => $request->addition_method,
                'path' => $request->path,
                'third_party_name' => $request->third_party_name,
                'time_duration' => ($request->hours * 60 * 60) + ($request->minutes * 60) + $request->seconds,
                'size' => null,
            ]);
        }

        return $this->responseOk('تم أضافة الفيديو الي المكتبة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(VideoLibrary $videoLibrary)
    {
        if($videoLibrary->addition_method == VideoLibrary::UPLOADED){
            unlink($videoLibrary->path);
        }
        $videoLibrary->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }
}
