<?php

namespace App\Http\Requests\Admin\UserRank;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserRankUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'rank' => 'sometimes|required|string|max:255',
        ];
    }
}
