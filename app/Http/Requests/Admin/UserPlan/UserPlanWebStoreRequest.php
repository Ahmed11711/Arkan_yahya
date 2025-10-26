<?php

namespace App\Http\Requests\Admin\UserPlan;
use App\Http\Requests\BaseRequest\BaseRequest;
class UserPlanWebStoreRequest extends BaseRequest
{
    

    public function rules(): array
    {
        return [
             'wallet_id' => 'required|integer|exists:wallets,id',
             'count_unite' => 'nullable|integer',
         
        ];
    }
}
