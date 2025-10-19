<?php

namespace App\Http\Resources\Admin\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'text' => $this->text,
            'push' => $this->push,
            'img' => $this->img,
            'service_id' => $this->service_id,
            'push_date' => $this->push_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
