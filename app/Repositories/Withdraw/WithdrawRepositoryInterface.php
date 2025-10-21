<?php

namespace App\Repositories\Withdraw;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface WithdrawRepositoryInterface extends BaseRepositoryInterface
{
                public function getByUserId(int $userId);

}
