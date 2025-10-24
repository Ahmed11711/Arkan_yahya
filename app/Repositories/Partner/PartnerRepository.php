<?php

namespace App\Repositories\Partner;

use App\Repositories\Partner\PartnerRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Partner;

class PartnerRepository extends BaseRepository implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}
