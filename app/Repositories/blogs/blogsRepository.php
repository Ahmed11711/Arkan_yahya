<?php

namespace App\Repositories\blogs;

use App\Repositories\blogs\blogsRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\blogs;

class blogsRepository extends BaseRepository implements blogsRepositoryInterface
{
    public function __construct(blogs $model)
    {
        parent::__construct($model);
    }
}
