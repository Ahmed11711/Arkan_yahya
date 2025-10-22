<?php

namespace App\Http\Requests\Admin\UserKyc;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserKycStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'front_id' => 'required|string|max:255',
            'back_id' => 'required|string|max:255',
            'face' => 'required|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }
}
