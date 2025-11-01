<?php

namespace App\Http\Resources\Admin\UserRank;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRankResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->name ?? null,
            'rank' => $this->rank,
            'count_direct'=>$this->count_direct,
            'count_indirect'=>$this->count_indirect,
            'count_direct_active'=>$this->count_direct_active,
            'count_indirect_active'=>$this->count_indirect_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
