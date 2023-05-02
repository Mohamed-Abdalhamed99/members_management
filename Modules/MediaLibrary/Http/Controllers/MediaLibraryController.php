<?php

namespace Modules\MediaLibrary\Http\Controllers;

use App\Models\MediaLibrary;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\MediaLibrary\Http\Requests\EmbedFileRequest;
use Modules\MediaLibrary\Http\Requests\UpdateEmbeddedFileRequest;
use Modules\MediaLibrary\Http\Requests\UpdateUploadedFileRequest;
use Modules\MediaLibrary\Http\Requests\UploadFileRequest;
use Modules\MediaLibrary\Transformers\EmbeddedFilesResource;
use Modules\MediaLibrary\Transformers\UploadedFilesResource;
use Spatie\QueryBuilder\QueryBuilder;

class MediaLibraryController extends Controller
{
    use HttpResponse;

    /**
     * get uploaded files
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUploadedFiles(){
        $files = QueryBuilder::for(MediaLibrary::class)
            ->where('addition_method',MediaLibrary::UPLOADED)
            ->defaultSort('-created_at')
            ->allowedSorts(['name' , 'size' , 'mime_type'])
            ->allowedFilters(['name' , 'size' , 'mime_type'])
            ->paginate(request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(UploadedFilesResource::collection($files)->response()->getData(true));
    }

    /**
     * get embedded files
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmbeddedFiles(){
        $files = QueryBuilder::for(MediaLibrary::class)
            ->where('addition_method',MediaLibrary::EMBED)
            ->defaultSort('-created_at')
            ->allowedSorts(['name' ,'mime_type'])
            ->allowedFilters(['name' , 'mime_type'])
            ->paginate(request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(EmbeddedFilesResource::collection($files)->response()->getData(true));
    }

    /**
     * upload file from user device
     *
     * @param UploadFileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(UploadFileRequest $request){
        $file_type = $request->file('file')->getClientOriginalExtension();
        $file_name = md5($request->file('file')->getClientOriginalName() . time()).'.'.$file_type;
        $file_size = $request->file('file')->getSize(); // byte size
        $request->file('file')->move('media_library' , $file_name);

        $media = MediaLibrary::create([
            'name' => $request->name,
            'path' => 'media_library/'.$file_name,
            'file_name' => $file_name,
            'mime_type' => $file_type,
            'size' => $file_size,
            'addition_method' => MediaLibrary::UPLOADED,
        ]);

        return $this->responseCreated($media , 'تم رفع المحتوي الي المكتبة بنجاح');
    }

    /**
     * embed file from online url
     *
     * @param EmbedFileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function embedFile(EmbedFileRequest $request){
        $media = MediaLibrary::create([
            'name' => $request->name,
            'path' => $request->path,
            'mime_type' => $request->mime_type,
            'addition_method' =>  MediaLibrary::EMBED
        ]);
        return $this->responseCreated($media , 'تم إضافة المحتوي الي المكتبة بنجاح');
    }

    /**
     * update uploaded files
     *
     * @param MediaLibrary $mediaLibrary
     * @param UpdateUploadedFileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUploadedFile(MediaLibrary $mediaLibrary , UpdateUploadedFileRequest $request)
    {

        //validate addition_method
        if($mediaLibrary->addition_method != MediaLibrary::UPLOADED){
            return $this->responseUnProcess('addition method not allowed for this action');
        }

        if($request->hasFile('file')){

            unlink($mediaLibrary->path);

            $file_type = $request->file('file')->getClientOriginalExtension();
            $file_name = md5($request->file('file')->getClientOriginalName() . time()).'.'.$file_type;
            $file_size = $request->file('file')->getSize(); // byte size
            $request->file('file')->move('media_library' , $file_name);

            $mediaLibrary->update([
                'name' => $request->name,
                'path' => 'media_library/'.$file_name,
                'file_name' => $file_name,
                'mime_type' => $file_type,
                'size' => $file_size,
                'addition_method' => MediaLibrary::UPLOADED,
            ]);
        }else{
            $mediaLibrary->update([ 'name' => $request->name]);
        }
        return $this->responseOk('تم تعديل المحتوي بنجاح');
    }

    public function updateEmbeddedFile(MediaLibrary $mediaLibrary , UpdateEmbeddedFileRequest $request)
    {
        //validate addition_method
        if($mediaLibrary->addition_method != MediaLibrary::EMBED){
            return $this->responseUnProcess('addition method not allowed for this action');
        }

        $mediaLibrary->update($request->validated());
        return $this->responseOk('تم تعديل المحتوي بنجاح');
    }

    /**
     * delete uploaded file from disk and delete from database
     *
     * @param MediaLibrary $mediaLibrary
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUploadedFiles(MediaLibrary $mediaLibrary)
    {
        //validate addition_method
        if($mediaLibrary->addition_method != MediaLibrary::UPLOADED){
            return $this->responseUnProcess('addition method not allowed for this action');
        }

        unlink($mediaLibrary->path);
        $mediaLibrary->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }

    /**
     * deleted embedded file url from database
     *
     * @param MediaLibrary $mediaLibrary
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEmbeddedFiles(MediaLibrary $mediaLibrary)
    {
        //validate addition_method
        if($mediaLibrary->addition_method != MediaLibrary::EMBED){
            return $this->responseUnProcess('addition method not allowed for this action');
        }

        $mediaLibrary->delete();
        return $this->responseOk('تم الحذف بنجاح');
    }

}
