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
            'userName' => $this->user->name ?? null,
            'text' => $this->text,
            'img' => $this->img ? url('/private/blogs/' . basename($this->img)) : null,
            'service_id' => $this->service_id,
       
        ];
    }
}
