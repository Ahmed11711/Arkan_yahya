<?php

namespace App\Repositories\UserKyc;

use App\Repositories\UserKyc\UserKycRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\UserKyc;

class UserKycRepository extends BaseRepository implements UserKycRepositoryInterface
{
    public function __construct(UserKyc $model)
    {
        parent::__construct($model);
    }
}
