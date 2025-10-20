<?php

namespace App\Repositories\Rank;

use App\Repositories\Rank\RankRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Rank;

class RankRepository extends BaseRepository implements RankRepositoryInterface
{
    public function __construct(Rank $model)
    {
        parent::__construct($model);
    }
}
