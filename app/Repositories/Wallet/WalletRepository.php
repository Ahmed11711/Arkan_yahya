<?php

namespace App\Repositories\Wallet;

use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Wallet;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }
}
