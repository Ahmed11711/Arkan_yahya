<?php

namespace App\Http\Requests\Admin\ads;
use App\Http\Requests\BaseRequest\BaseRequest;
class adsStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
    'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'required|integer',
            'url' => 'nullable|string|max:255',
            'expire' => 'nullable|date',
        ];
    }
}
