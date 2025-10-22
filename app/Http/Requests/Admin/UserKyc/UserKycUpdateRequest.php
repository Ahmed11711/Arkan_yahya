<?php

namespace App\Http\Requests\Admin\UserKyc;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserKycUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'front_id' => 'sometimes|required|string|max:255',
            'back_id' => 'sometimes|required|string|max:255',
            'face' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:pending,approved,rejected',
        ];
    }
}
