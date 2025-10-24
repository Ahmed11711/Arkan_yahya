<?php

namespace App\Http\Requests\Admin\User;
 use App\Http\Requests\BaseRequest\BaseRequest;

 
class UserStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'coming_affiliate' => 'required|string|max:255|exists:users,affiliate_code',
            'affiliate_code_active'=>'required|boolean',
            'active' => 'nullable|boolean',
            'verified_kyc' => 'nullable|boolean',
            'type' => 'required|in:user,guest',
         ];
    }
}
