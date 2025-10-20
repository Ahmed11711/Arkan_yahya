<?php

namespace App\Http\Requests\Admin\Rank;
use App\Http\Requests\BaseRequest\BaseRequest;
class RankStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'count_direct' => 'required|integer',
            'count_undirect' => 'required|integer',
            'profit_g1' => 'required|numeric',
            'profit_g2' => 'required|numeric',
            'profit_g3' => 'required|numeric',
            'profit_g4' => 'required|numeric',
            'profit_g5' => 'required|numeric',
        ];
    }
}
