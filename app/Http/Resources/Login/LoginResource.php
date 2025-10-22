<?php

namespace App\Http\Resources\Login;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'email_verified_at'=>$this->email_verified_at,
            'phone'=>$this->phone,
            'affiliate_code'=>$this->affiliate_code,
            'coming_affiliate'=>$this->coming_affiliate,
            'active'=>(boolean)$this->active,
            'verified_kyc'=>(boolean)$this->verified_kyc,
            'img'=>'https://avatars.mds.yandex.net/i?id=4e4413b9837aad3dadbd008358c9c731cc90078b-5244992-images-thumbs&n=13',
            'address'=>'TCw6YaWm3y6DvxY7M8hrCDnrJGeGMumzGJ',
         ];
    }
}
