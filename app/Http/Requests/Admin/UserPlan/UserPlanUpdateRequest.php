<?php

namespace App\Http\Requests\Admin\UserPlan;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserPlanUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'wallet_id' => 'sometimes|required|integer|exists:wallets,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'transaction_id' => 'nullable|sometimes|string|max:255',
            'status' => 'sometimes|required|in:active,expired,pending,cancelled',
            'price' => 'sometimes|required|numeric',
        ];
    }
}
