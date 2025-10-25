<?php

namespace App\Http\Controllers\Admin\UserTransaction;

use App\Repositories\UserTransaction\UserTransactionRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\UserTransaction\UserTransactionStoreRequest;
use App\Http\Requests\Admin\UserTransaction\UserTransactionUpdateRequest;
use App\Http\Resources\Admin\UserTransaction\UserTransactionResource;

class UserTransactionController extends BaseController
{
    public function __construct(UserTransactionRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'UserTransaction'
        );

        $this->storeRequestClass = UserTransactionStoreRequest::class;
        $this->updateRequestClass = UserTransactionUpdateRequest::class;
        $this->resourceClass = UserTransactionResource::class;
    }
}
