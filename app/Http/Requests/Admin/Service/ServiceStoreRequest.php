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
            'desc' => 'required|string',
            'img' => 'nullable|file|max:2048',
            'push' => 'required|integer',
            'push_date' => 'required|date',
        ];
    }
}
