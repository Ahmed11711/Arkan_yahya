<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;

class VerificationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'method' => 'required|in:email,sms,app',
        ];
    }
}
