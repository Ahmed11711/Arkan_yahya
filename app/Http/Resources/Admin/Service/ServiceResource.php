<?php

namespace App\Http\Resources\Admin\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
             'title' => $this->title,
            'title_en' => $this->title_en ?? $this->title,
            'desc' => $this->desc,
            'desc_en' => $this->desc_en ?? $this->desc,
            'img' => $this->img ?? null,
            'push' => $this->push,
            'push_date' => $this->push_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            ///
        ];
    }
}
