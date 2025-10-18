<?php

namespace App\Http\Requests\Kyc;

use App\Http\Requests\BaseRequest\BaseRequest;
 
class KycRequest extends BaseRequest
{
     

    
    public function rules(): array
    {
        return [
            'user_id'=>'required|exists:users,id',
            'front_id' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'back_id'  => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'face'     => 'required|file|mimes:jpeg,png,jpg|max:4096',

        ];
    }
}
