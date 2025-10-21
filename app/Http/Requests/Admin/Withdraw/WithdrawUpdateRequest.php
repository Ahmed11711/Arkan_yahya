<?php

namespace App\Http\Requests\Admin\Withdraw;
use App\Http\Requests\BaseRequest\BaseRequest;
class WithdrawUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'transaction_id' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'symbol' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:pending,completed,failed',
        ];
    }
}
