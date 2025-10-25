<?php

namespace App\Repositories\UserTransaction;

use App\Repositories\UserTransaction\UserTransactionRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\UserTransaction;

class UserTransactionRepository extends BaseRepository implements UserTransactionRepositoryInterface
{
    public function __construct(UserTransaction $model)
    {
        parent::__construct($model);
    }
}
