<?php

namespace App\Http\Requests\Admin\Blog;
 use App\Http\Requests\BaseRequest\BaseRequest;

use Illuminate\Foundation\Http\BaseRequest;

class BlogUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'text' => 'sometimes|required|string',
            'push' => 'sometimes|required|integer',
            'img' => 'nullable|sometimes|string|max:255|file|max:2048',
        ];
    }
}
