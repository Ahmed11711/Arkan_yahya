<?php

namespace App\Repositories\Deposit;

use App\Repositories\Deposit\DepositRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Deposit;

class DepositRepository extends BaseRepository implements DepositRepositoryInterface
{
    public function __construct(Deposit $model)
    {
        parent::__construct($model);
    }

        public function getByUserId($userId)
        {
         return $this->model->where('user_id', $userId)->get();
        }
}
