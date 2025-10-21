<?php

namespace App\Repositories\Deposit;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface DepositRepositoryInterface extends BaseRepositoryInterface
{
            public function getByUserId(int $userId);

}
