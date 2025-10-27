<?php

namespace App\Http\Requests\Admin\Wallet;
use App\Http\Requests\BaseRequest\BaseRequest;
class WalletStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'desc' => 'required|string',
            'desc_en' => 'nullable|string',
            'amount' => 'required|numeric',
            'profit_rate' => 'required|string',
            'profit_cycle' => 'required|integer',
            'duration_months' => 'nullable|integer',
            'capital_return' => 'required|integer',
            'affiliate_commission_rate' => 'required|numeric',
            'status' => 'required|in:active,completed,pending',
            'early_withdraw_penalty' => 'nullable|numeric',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'minimum_count' => 'nullable|integer',
            'service_id' => 'required|integer|exists:services,id',
        ];
    }
}
