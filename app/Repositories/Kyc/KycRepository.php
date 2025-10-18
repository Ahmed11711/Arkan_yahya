<?php

namespace App\Repositories\Kyc;

use App\Repositories\Kyc\KycRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
 use App\Models\UserKyc as ModelsUserKyc;

class KycRepository extends BaseRepository implements KycRepositoryInterface
{
    public function __construct(ModelsUserKyc $model)
    {
        parent::__construct($model);
    }

   

}
