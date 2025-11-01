<?php

namespace App\Http\Resources\Admin\Withdraw;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->name ?? null,
            'transaction_id' => $this->transaction_id,
            'address' => $this->address,
            'symbol' => $this->symbol,
            'amount' => $this->amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
