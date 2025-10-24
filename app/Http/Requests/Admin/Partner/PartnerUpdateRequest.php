<?php

namespace App\Http\Requests\Admin\Partner;
use App\Http\Requests\BaseRequest\BaseRequest;
class PartnerUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|sometimes|string|max:255',
            'title' => 'nullable|sometimes|string|max:255',
                'img' => 'sometimes|mimes:jpeg,png,jpg,gif,webp|max:2048',
         ];
    }
}
