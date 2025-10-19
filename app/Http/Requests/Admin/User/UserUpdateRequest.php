<?php

namespace App\Http\Requests\Admin\User;
 use App\Http\Requests\BaseRequest\BaseRequest;

 
class UserUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255|unique:users,email,'.$this->route('user').',id',
            'email_verified_at' => 'nullable|sometimes|date',
            'password' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|sometimes|string|max:255',
             'active' => 'sometimes|required|boolean',
            'verified_kyc' => 'sometimes|required|boolean',
            'type' => 'sometimes|required|in:user,guest',
         ];
    }
}
