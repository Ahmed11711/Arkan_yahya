<?php

namespace App\Http\Requests\Admin\UserPlan;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserPlanStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'wallet_id' => 'required|integer|exists:wallets,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,pending,cancelled',
            'price' => 'required|numeric',
        ];
    }
}
