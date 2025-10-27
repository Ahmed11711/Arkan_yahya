<?php

namespace App\Http\Requests\Admin\Service;
use App\Http\Requests\BaseRequest\BaseRequest;
class ServiceStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'desc' => 'required|string',
            'desc_en' => 'nullable|string',
            'about_desc_en' => 'nullable|string',
            'about_desc' => 'nullable|string',
    'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'push' => 'required|integer',
            'push_date' => 'required|date',
        ];
    }
}
