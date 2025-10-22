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
            'front_id' => $this->img ? asset('storage/app/public/' . $this->front_id) : null,
            'back_id' => $this->img ? asset('storage/app/public/' . $this->back_id) : null,
            'face' => $this->img ? asset('storage/app/public/' . $this->face) : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
