<?php

namespace App\Http\Requests\Admin\Wallet;
use App\Http\Requests\BaseRequest\BaseRequest;
class WalletUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'desc' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric',
            'profit_rate' => 'sometimes|required|numeric',
            'profit_cycle' => 'sometimes|required|integer',
            'duration_months' => 'nullable|sometimes|integer',
            'capital_return' => 'sometimes|required|integer',
            'affiliate_commission_rate' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:active,completed,pending',
            'early_withdraw_penalty' => 'nullable|sometimes|numeric',
            'img' => 'nullable|sometimes|string|max:255|file|max:2048',
            'service_id' => 'sometimes|required|integer|exists:services,id',
        ];
    }
}
