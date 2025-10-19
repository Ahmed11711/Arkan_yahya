<?php

namespace App\Http\Resources\Admin\Blogs;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsWebResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'userName' => $this->user->name ?? 'ahmed',
            'userImg' => 'https://t3.ftcdn.net/jpg/01/04/93/56/360_F_104935633_9dB5CW1aSk35RYSXQPYOCudPMku6vMFv.jpg',
            'text' => $this->text,
            'push' => $this->push,
            'img' => $this->img ? url('/private/blogs/' . basename($this->img)) : null,
            'service_id' => $this->service_id,
             'created_at' => $this->created_at,
         ];
    }
}
