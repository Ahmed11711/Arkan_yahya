<?php

namespace App\Http\Controllers\Admin\User;

 use App\Http\Resources\Admin\User\UserResource;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Http\Controllers\BaseController\BaseController;

class UserController extends BaseController
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'User'
        );

        $this->storeRequestClass = UserStoreRequest::class;
        $this->updateRequestClass = UserUpdateRequest::class;
        $this->resourceClass = UserResource::class;
    }

   
}
