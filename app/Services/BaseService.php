<?php

namespace App\Services\SendOtp;

use App\Services\AttachmentService\AttachmentService;
use Illuminate\Support\Facades\Log;
use Modules\Facilities\Services\CompleteFacilityService;

class BaseService
{
    protected $repository;
   
    protected string $pageName;


    public function __construct($repository, string $pageName)
    {
        $this->repository = $repository;
    
        $this->pageName = $pageName;
    }

    public function all()
    {
        return $this->repository->all();
    }
    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function save(array $data, ?int $id = null)
    {
        $files = $data['files'] ?? null;
         unset($data['files']);
        $record = $id
            ? $this->repository->update($id, $data)
            : $this->repository->create($data);

      
        return $record;
    }

    
    public function delete(array $ids): int
    {
        return $this->repository->deleteWithAttachments($ids);
    }
}
