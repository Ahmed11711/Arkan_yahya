<?php

namespace App\Http\Requests\Admin\ads;
use App\Http\Requests\BaseRequest\BaseRequest;
class adsUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'desc' => 'sometimes|required|string',
    'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'sometimes|required|integer',
            'url' => 'nullable|sometimes|string|max:255',
            'expire' => 'sometimes|required|date',
        ];
    }
}
