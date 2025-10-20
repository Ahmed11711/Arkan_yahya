<?php

namespace App\Http\Requests\Admin\Blogs;
use App\Http\Requests\BaseRequest\BaseRequest;
class BlogsStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
             'text' => 'required|string',
            'push' => 'required|boolean',
    'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'service_id' => 'required|integer|exists:services,id',
            'push_date' => 'required|date',
        ];
    }
}
