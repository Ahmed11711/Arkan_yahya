<?php

namespace App\Http\Controllers\Admin\UserRank;

use App\Repositories\UserRank\UserRankRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\UserRank\UserRankStoreRequest;
use App\Http\Requests\Admin\UserRank\UserRankUpdateRequest;
use App\Http\Resources\Admin\UserRank\UserRankResource;

class UserRankController extends BaseController
{
    public function __construct(UserRankRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'UserRank'
        );

        $this->storeRequestClass = UserRankStoreRequest::class;
        $this->updateRequestClass = UserRankUpdateRequest::class;
        $this->resourceClass = UserRankResource::class;
    }
}
