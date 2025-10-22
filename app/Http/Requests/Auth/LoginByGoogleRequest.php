<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest\BaseRequest;

class LoginByGoogleRequest extends BaseRequest
{
   
     
    public function rules(): array
    {
        return [
            'id_token'=>'required|string'
        ];
    }
}
