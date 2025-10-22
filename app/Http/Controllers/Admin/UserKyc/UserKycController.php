<?php

namespace App\Http\Controllers\Admin\UserKyc;

use App\Repositories\UserKyc\UserKycRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\UserKyc\UserKycStoreRequest;
use App\Http\Requests\Admin\UserKyc\UserKycUpdateRequest;
use App\Http\Resources\Admin\UserKyc\UserKycResource;

class UserKycController extends BaseController
{
    public function __construct(UserKycRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'UserKyc'
        );

        $this->storeRequestClass = UserKycStoreRequest::class;
        $this->updateRequestClass = UserKycUpdateRequest::class;
        $this->resourceClass = UserKycResource::class;
    }
}
