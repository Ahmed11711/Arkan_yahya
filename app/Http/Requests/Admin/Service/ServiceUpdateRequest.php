<?php

namespace App\Http\Requests\Admin\Service;
use App\Http\Requests\BaseRequest\BaseRequest;
class ServiceUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'desc' => 'sometimes|required|string',
            'desc_en' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'push' => 'sometimes|required|integer',
            'push_date' => 'sometimes|required|date',
        ];
    }
}
