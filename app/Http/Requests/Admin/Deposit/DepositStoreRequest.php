<?php

namespace App\Http\Requests\Admin\Deposit;
use App\Http\Requests\BaseRequest\BaseRequest;
class DepositStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'transaction_id' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
        ];
    }
}
