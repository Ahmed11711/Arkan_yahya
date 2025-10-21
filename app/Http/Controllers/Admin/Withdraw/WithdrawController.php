<?php

namespace App\Http\Controllers\Admin\Withdraw;

use App\Repositories\Withdraw\WithdrawRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Withdraw\WithdrawStoreRequest;
use App\Http\Requests\Admin\Withdraw\WithdrawUpdateRequest;
use App\Http\Resources\Admin\Withdraw\WithdrawResource;

class WithdrawController extends BaseController
{
    public function __construct(WithdrawRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Withdraw'
        );

        $this->storeRequestClass = WithdrawStoreRequest::class;
        $this->updateRequestClass = WithdrawUpdateRequest::class;
        $this->resourceClass = WithdrawResource::class;
    }
}
