<?php

namespace App\Http\Resources\Admin\Blogs;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'userName' => $this->user->name ?? null,
            'text' => $this->text,
            'push' => $this->push,
            'img' => $this->img ? url('/private/blogs/' . basename($this->img)) : null,
            'service_id' => $this->service_id,
            'push_date' => $this->push_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
