<?php

namespace App\Http\Controllers\Admin\ads;

use App\Repositories\ads\adsRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\ads\adsStoreRequest;
use App\Http\Requests\Admin\ads\adsUpdateRequest;
use App\Http\Resources\Admin\ads\adsResource;

class adsController extends BaseController
{
    public function __construct(adsRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'ads',
            fileFields: ['img']
        );

        $this->storeRequestClass = adsStoreRequest::class;
        $this->updateRequestClass = adsUpdateRequest::class;
        $this->resourceClass = adsResource::class;
    }
}
