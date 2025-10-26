<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends BaseRequest
{
     

   
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'otp_code' => 'nullable|string|min:6|max:6',
        ];
    }
}
