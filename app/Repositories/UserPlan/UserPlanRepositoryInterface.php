<?php

namespace App\Repositories\UserPlan;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface UserPlanRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUserIdWithRelations($userId,$relation);
}
