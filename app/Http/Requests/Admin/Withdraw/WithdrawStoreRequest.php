<?php

namespace App\Http\Requests\Admin\Withdraw;
use App\Http\Requests\BaseRequest\BaseRequest;
class WithdrawStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'user_id' => 'required|integer|exists:users,id',
            // 'transaction_id' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.000001', // يمنع السحب صفر أو سلبي
         ];
    }
}
