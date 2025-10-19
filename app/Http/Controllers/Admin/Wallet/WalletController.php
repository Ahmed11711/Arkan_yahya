<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Wallet\WalletStoreRequest;
use App\Http\Requests\Admin\Wallet\WalletUpdateRequest;
use App\Http\Resources\Admin\Wallet\WalletResource;

class WalletController extends BaseController
{
    public function __construct(WalletRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Wallet',
            fileFields: ['img']
        );

        $this->storeRequestClass = WalletStoreRequest::class;
        $this->updateRequestClass = WalletUpdateRequest::class;
        $this->resourceClass = WalletResource::class;
    }
}
