<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required'],
            'password' => [
                'required',
                'string',
                'min:8',
                'not_in:password,123456',
            ],
            'type' => 'required|in:user,guest',
            // 'coming_affiliate' => 'sometimes|string|exists:users,affiliate_code'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not exceed 255 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already taken.',

            'phone.required' => 'The phone field is required.',
            'phone.regex' => 'The phone number must start with the country code (+) followed by numbers.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 12 characters.',
            'password.regex' => 'The password must contain an uppercase letter, a lowercase letter, a number, and a special symbol.',
            'password.not_in' => 'The password is too weak.',

            'type.required' => 'The user type field is required.',
            'type.in' => 'The user type must be either "user" or "guest".',

            'affiliate_code.string' => 'The affiliate code must be a string.',
            'affiliate_code.exists' => 'The affiliate code does not exist.'
        ];
    }
}
