<?php

namespace App\Repositories\Withdraw;

use App\Repositories\Withdraw\WithdrawRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Withdraw;

class WithdrawRepository extends BaseRepository implements WithdrawRepositoryInterface
{
    public function __construct(Withdraw $model)
    {
        parent::__construct($model);
    }

      
}
