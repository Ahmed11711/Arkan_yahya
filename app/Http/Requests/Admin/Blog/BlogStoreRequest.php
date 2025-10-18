<?php

namespace App\Http\Requests\Admin\Blog;
 use App\Http\Requests\BaseRequest\BaseRequest;

use Illuminate\Foundation\Http\BaseRequest;

class BlogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'text' => 'required|string',
            'push' => 'required|integer',
            'img' => 'nullable|string|max:255|file|max:2048',
        ];
    }
}
