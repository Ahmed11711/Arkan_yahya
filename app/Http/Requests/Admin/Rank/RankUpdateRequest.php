<?php

namespace App\Http\Requests\Admin\Rank;
use App\Http\Requests\BaseRequest\BaseRequest;
class RankUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|sometimes|string',
            'count_direct' => 'sometimes|required|integer',
            'count_undirect' => 'sometimes|required|integer',
            'profit_g1' => 'sometimes|required|numeric',
            'profit_g2' => 'sometimes|required|numeric',
            'profit_g3' => 'sometimes|required|numeric',
            'profit_g4' => 'sometimes|required|numeric',
            'profit_g5' => 'sometimes|required|numeric',
        ];
    }
}
