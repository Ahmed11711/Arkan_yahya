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
            'userName' => $this->user->name ?? "admin",
            'text' => $this->text,
            'push' => $this->push,
            'img' => $this->img ?? null,
            'serviceName' => $this->service->title ?? "service",
            'push_date' => $this->push_date?->format('Y-m-d'), // ←  
            'created_at' => $this->push_date?->format('Y-m-d'), // ←  
            'updated_at' => $this->push_date?->format('Y-m-d'), // ←  


        ];
    }
}
