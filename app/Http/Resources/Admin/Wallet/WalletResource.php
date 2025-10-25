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
            'name_en' => $this->name_en ?? $this->name,
            'desc' => $this->desc,
            'desc_en' => $this->desc_en ?? $this->desc,
            'amount' => $this->amount,
            'profit_rate' => $this->profit_rate,
            'profit_cycle' => $this->profit_cycle,
            'duration_months' => $this->duration_months,
            'capital_return' => $this->capital_return,
            'affiliate_commission_rate' => $this->affiliate_commission_rate,
            'status' => $this->status,
            'early_withdraw_penalty' => $this->early_withdraw_penalty,
            'img' => $this->img,
            'serviceName' => $this->service->title ?? "service",
              'created_at' => $this->push_date?->format('Y-m-d'), // ←  
            'updated_at' => $this->push_date?->format('Y-m-d'), // ←  
        ];
    }
}
