<?php

namespace App\Http\Resources\Admin\UserKyc;

use Illuminate\Http\Resources\Json\JsonResource;

class UserKycResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'front_id' => $this->front_id,
            'back_id' => $this->back_id,
            'face' => $this->face,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
