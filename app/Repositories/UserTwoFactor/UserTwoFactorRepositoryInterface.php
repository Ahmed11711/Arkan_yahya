<?php

namespace App\Repositories\UserTwoFactor;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface UserTwoFactorRepositoryInterface extends BaseRepositoryInterface
{
         public function createOrUpdate(array $data);
         public function findByConditions(array $conditions);

}
