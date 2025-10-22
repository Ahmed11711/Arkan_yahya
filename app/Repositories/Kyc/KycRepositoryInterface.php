<?php

namespace App\Repositories\Kyc;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

interface KycRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUserId(int $userId);
 }
