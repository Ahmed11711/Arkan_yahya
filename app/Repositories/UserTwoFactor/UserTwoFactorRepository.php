<?php

namespace App\Repositories\UserTwoFactor;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
 use App\Models\UserTwoFactor;

class UserTwoFactorRepository extends BaseRepository implements UserTwoFactorRepositoryInterface
{
    public function __construct(UserTwoFactor $model)
    {
        parent::__construct($model);
    }

     public function createOrUpdate(array $data)
    {
        return $this->model->updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'type'    => $data['type'], 
            ],
            $data
        );
    }

     public function findByConditions(array $conditions)
    {
        return $this->model->where($conditions)->latest()->first();
    }
}
