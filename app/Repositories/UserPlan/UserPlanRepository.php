<?php

namespace App\Repositories\UserPlan;

use App\Repositories\UserPlan\UserPlanRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\UserPlan;

class UserPlanRepository extends BaseRepository implements UserPlanRepositoryInterface
{
    public function __construct(UserPlan $model)
    {
        parent::__construct($model);
    }

    public function getByUserId($userId)
    {
        
    }
}
