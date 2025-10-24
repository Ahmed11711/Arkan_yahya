<?php

namespace App\Http\Controllers\Admin\UserPlan;

use App\Repositories\UserPlan\UserPlanRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\UserPlan\UserPlanStoreRequest;
use App\Http\Requests\Admin\UserPlan\UserPlanUpdateRequest;
use App\Http\Resources\Admin\UserPlan\UserPlanResource;

class UserPlanController extends BaseController
{
    public function __construct(UserPlanRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'UserPlan'
        );

        $this->storeRequestClass = UserPlanStoreRequest::class;
        $this->updateRequestClass = UserPlanUpdateRequest::class;
        $this->resourceClass = UserPlanResource::class;
    }
}
