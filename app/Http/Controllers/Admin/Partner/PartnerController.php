<?php

namespace App\Http\Controllers\Admin\Partner;

use App\Repositories\Partner\PartnerRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Partner\PartnerStoreRequest;
use App\Http\Requests\Admin\Partner\PartnerUpdateRequest;
use App\Http\Resources\Admin\Partner\PartnerResource;

class PartnerController extends BaseController
{
    public function __construct(PartnerRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Partner',
            fileFields: ['img']
        );

        $this->storeRequestClass = PartnerStoreRequest::class;
        $this->updateRequestClass = PartnerUpdateRequest::class;
        $this->resourceClass = PartnerResource::class;
    }
}
