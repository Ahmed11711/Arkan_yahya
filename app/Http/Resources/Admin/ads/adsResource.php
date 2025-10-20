<?php

namespace App\Http\Resources\Admin\ads;

use Illuminate\Http\Resources\Json\JsonResource;

class adsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'img' => $this->img,
            'active' => $this->active,
            'url' => $this->url,
            'expire' => $this->expire,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
