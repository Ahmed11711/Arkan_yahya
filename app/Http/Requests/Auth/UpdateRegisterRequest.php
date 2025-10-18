<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Support\Facades\Log;

class UpdateRegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        $userId = $this->route('user') ?? optional($this->user())->id;

        return [
            'name' => 'sometimes|string|max:255|min:2',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => 'sometimes|string|max:20',
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8',
                'not_in:password,123456',
            ],
            'type' => 'sometimes|in:user,guest,admin',
            'active'=>'sometimes|boolean',
            'coming_affiliate' => 'sometimes|string|exists:users,coming_affiliate',
        ];
    }
}
