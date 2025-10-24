<?php

namespace App\Http\Requests\Admin\Partner;
use App\Http\Requests\BaseRequest\BaseRequest;
class PartnerStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
    'img' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
