<?php

namespace App\Http\Requests\Admin\UserTransaction;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserTransactionUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'type' => 'sometimes|required|in:withdraw,deposit,affiliate,plan',
            'type_id' => 'nullable|sometimes|integer',
            'amount' => 'sometimes|required|string|max:255',
        ];
    }
}
