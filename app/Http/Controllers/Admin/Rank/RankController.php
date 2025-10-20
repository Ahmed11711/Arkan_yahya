<?php

namespace App\Http\Controllers\Admin\Rank;

use App\Repositories\Rank\RankRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Rank\RankStoreRequest;
use App\Http\Requests\Admin\Rank\RankUpdateRequest;
use App\Http\Resources\Admin\Rank\RankResource;

class RankController extends BaseController
{
    public function __construct(RankRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Rank'
        );

        $this->storeRequestClass = RankStoreRequest::class;
        $this->updateRequestClass = RankUpdateRequest::class;
        $this->resourceClass = RankResource::class;
    }
}
