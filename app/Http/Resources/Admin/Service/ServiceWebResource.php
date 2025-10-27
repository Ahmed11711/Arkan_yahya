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
            'title_en' => $this->title_en ?? $this->title,
            'desc' => $this->desc,
            'desc_en' => $this->desc_en ?? $this->desc,
            'about_desc_en'=> $this->about_desc_en ?? $this->about_desc,
            'about_desc'=> $this->about_desc,
            'img' => $this->img  ?? "https://www.luxurylifestylemag.co.uk/wp-content/uploads/2020/11/bigstock-Investment-Glass-Jar-With-Coi-382984313.jpg",
            'plans' => WalletResource::collection($this->wallets),
            /////ddddd
        ];
    }
}
