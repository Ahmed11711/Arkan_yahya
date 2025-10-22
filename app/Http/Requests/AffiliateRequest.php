<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest\BaseRequest;
 
class AffiliateRequest extends BaseRequest
{
    

   
    public function rules(): array
    {
        return [
            'user_id'=>'required|integer|exists:users,id',
         ];
    }
}
