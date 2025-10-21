<?php

namespace App\Http\Controllers\Admin\Deposit;

use App\Repositories\Deposit\DepositRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Deposit\DepositStoreRequest;
use App\Http\Requests\Admin\Deposit\DepositUpdateRequest;
use App\Http\Resources\Admin\Deposit\DepositResource;

class DepositController extends BaseController
{
    public function __construct(DepositRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Deposit'
        );

        $this->storeRequestClass = DepositStoreRequest::class;
        $this->updateRequestClass = DepositUpdateRequest::class;
        $this->resourceClass = DepositResource::class;
    }
}
