<?php

namespace App\Repositories\ads;

use App\Repositories\ads\adsRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\ads;

class adsRepository extends BaseRepository implements adsRepositoryInterface
{
    public function __construct(ads $model)
    {
        parent::__construct($model);
    }
}
