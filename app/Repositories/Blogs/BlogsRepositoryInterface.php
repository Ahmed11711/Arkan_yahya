<?php

namespace App\Repositories\Blogs;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface BlogsRepositoryInterface extends BaseRepositoryInterface
{
    public function getLatesByCount(int $count);
}
