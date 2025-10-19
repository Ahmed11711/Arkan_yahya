<?php

namespace App\Http\Requests\Admin\Blogs;
use App\Http\Requests\BaseRequest\BaseRequest;
class BlogsUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string',
             'text' => 'sometimes|required|string',
            'push' => 'sometimes|required|integer',
            'img' => 'nullable|sometimes|max:2048',
            'service_id' => 'sometimes|required|integer|exists:services,id',
            'push_date' => 'sometimes|required|date',
        ];
    }
}
