<?php

namespace App\Http\Resources\Admin\UserRank;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRankResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->name,
            'rank' => $this->rank,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
