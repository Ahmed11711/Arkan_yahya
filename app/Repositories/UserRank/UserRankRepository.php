<?php

namespace App\Repositories\UserRank;

use App\Repositories\UserRank\UserRankRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\UserRank;

class UserRankRepository extends BaseRepository implements UserRankRepositoryInterface
{
    public function __construct(UserRank $model)
    {
        parent::__construct($model);
    }
}
