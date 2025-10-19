<?php

namespace App\Http\Controllers\Api\Service;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
  use App\Http\Resources\Admin\Service\ServiceWebResource;
use App\Repositories\Service\ServiceRepositoryInterface;

class ServiceController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected ServiceRepositoryInterface $serviceRepo)
    {}

    public function index()
    {
        $services=$this->serviceRepo->allRelations(['wallets']);
        return $this->successResponse(ServiceWebResource::collection($services),'Services fetched successfully!');
    }
}
