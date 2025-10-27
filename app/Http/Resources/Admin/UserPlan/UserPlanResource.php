<?php

namespace App\Http\Resources\Admin\UserPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'wallet_name' => $this->wallet->name ?? null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'price' => $this->price,
            'count_unite' => $this->count_unite,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
