<?php

namespace App\Http\Requests\Admin\UserTransaction;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserTransactionStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'type' => 'required|in:withdraw,deposit,affiliate,plan',
            'type_id' => 'nullable|integer',
            'amount' => 'required|string|max:255',
        ];
    }
}
