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
                'name' => $this->user?->name ?? null,
                'email' => $this->user?->email ?? null,
                'generation' => $this->generation,
                'active' => $this->active,
                'block' => $this->block,
                'moony' => $this->moony,
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
              
            


        
    }
}
