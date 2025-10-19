<?php

namespace App\Http\Resources\Admin\Wallet;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'amount' => $this->amount,
            'profit_rate' => $this->profit_rate,
            'profit_cycle' => $this->profit_cycle,
            'duration_months' => $this->duration_months,
            'capital_return' => $this->capital_return,
            'affiliate_commission_rate' => $this->affiliate_commission_rate,
            'status' => $this->status,
            'early_withdraw_penalty' => $this->early_withdraw_penalty,
            'img' => $this->img,
            'service_id' => $this->service_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
