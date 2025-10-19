<?php

namespace App\Repositories\Blogs;

use App\Repositories\Blogs\BlogsRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Blog;

class BlogsRepository extends BaseRepository implements BlogsRepositoryInterface
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }
}
