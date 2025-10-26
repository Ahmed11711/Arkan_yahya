<?php

namespace App\Http\Resources\Affiliate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AffiliateResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
                'id' => $this->id,
                'user_id'=>$this->user->id ?? null,
                'name' => $this->user?->name ?? null,
                'email' => $this->user?->email ?? null,
                'phone' => $this->user?->phone ?? null,
                'generation' => $this->generation,
                'active' => $this->active,
                'affiliate_code'=>$this->user?->affiliate_code ?? null,
                'your_affiliate_link'=>'https://zayamrock.com'.'/auth?affiliate_code='.$this->user?->affiliate_code ?? null,

                'block' => $this->block,
                'money' => $this->moony,
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
              
            


        
    }
}
