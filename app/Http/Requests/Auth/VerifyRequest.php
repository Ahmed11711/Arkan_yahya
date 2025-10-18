<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;

class VerifyRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'method'  => 'required|in:email,sms,app',
            'code'   =>'required|string|min:6'
        ];
    }
}
