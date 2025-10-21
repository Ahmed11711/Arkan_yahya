<?php

namespace App\Http\Resources\Admin\Service;

use App\Http\Resources\Admin\Wallet\WalletResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceWebResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'img' => $this->img ? asset('storage/app/public/' . $this->img) : null,
            // 'push' => $this->push,
            // 'push_date' => $this->push_date,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'plans' => WalletResource::collection($this->wallets),
            //
        ];
    }
}
