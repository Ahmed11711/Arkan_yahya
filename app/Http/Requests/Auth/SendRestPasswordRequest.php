<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;
 
class SendRestPasswordRequest extends BaseRequest
{
    
    public function rules(): array
    {
        return [
            'method'=>'required|string|in:email,phone',
            'value' =>'required|string|min:6'
        ];
    }
}
