<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseRequest
{
   
  
    public function rules(): array
    {
        return [
            'email'=>'required|string|email|exists:users,email',
            'password'=>'required|string|min:8',
        ];
    }
}
