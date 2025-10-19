<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'phone' => $this->phone,
            'affiliate_code' => $this->affiliate_code,
            'coming_affiliate' => $this->coming_affiliate,
            'active' => $this->active,
            'verified_kyc' => $this->verified_kyc,
            'type' => $this->type,
            'remember_token' => $this->remember_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
