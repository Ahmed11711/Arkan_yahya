<?php

namespace App\Http\Requests\Admin\UserRank;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserRankStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'rank' => 'required|string|max:255',
        ];
    }
}
