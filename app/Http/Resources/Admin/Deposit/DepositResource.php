<?php

namespace App\Http\Resources\Admin\Deposit;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BaseResource\MetaResource\MetaResource;

class DepositResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'meta' => new MetaResource($this->resource), 

        ];
    }
}
