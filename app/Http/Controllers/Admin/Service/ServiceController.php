<?php

namespace App\Http\Controllers\Admin\Service;

use App\Repositories\Service\ServiceRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Service\ServiceStoreRequest;
use App\Http\Requests\Admin\Service\ServiceUpdateRequest;
use App\Http\Resources\Admin\Service\ServiceResource;

class ServiceController extends BaseController
{
    public function __construct(ServiceRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Service',
            fileFields: ['img']
        );

        $this->storeRequestClass = ServiceStoreRequest::class;
        $this->updateRequestClass = ServiceUpdateRequest::class;
        $this->resourceClass = ServiceResource::class;
    }
}
