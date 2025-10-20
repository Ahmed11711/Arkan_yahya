<?php

namespace App\Http\Resources\Admin\Rank;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'count_direct' => $this->count_direct,
            'count_undirect' => $this->count_undirect,
            'profit_g1' => $this->profit_g1,
            'profit_g2' => $this->profit_g2,
            'profit_g3' => $this->profit_g3,
            'profit_g4' => $this->profit_g4,
            'profit_g5' => $this->profit_g5,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
