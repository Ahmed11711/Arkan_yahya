<?php

namespace App\Repositories\Service;

use App\Repositories\Service\ServiceRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Service;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }
}
