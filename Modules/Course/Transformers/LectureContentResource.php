<?php

namespace Modules\Course\Transformers;

use App\Models\LectureContent;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\VidoeLibrary\Transformers\VideoLibraryResource;

class LectureContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => [
                'value' => $this->type,
                'display_name' => $this->type_name,
            ],
            'content' => $this->getContentMedia()
        ];
    }

    private function getContentMedia()
    {
        if ($this->type == LectureContent::VIDEO) {
            $video = $this->video;

            return [
                'url' => $video->url,
                'name' => $video->name,
            ];
        } elseif ($this->type == LectureContent::ARTICLE) {
            return [
                'article' => $this->article
            ];
        } else {
            $media =  $this->getFirstMedia('lec_content');
            return [
                'url' => $media['original_url'],
                'name' => $media['name'],
            ];
        }
    }
}
