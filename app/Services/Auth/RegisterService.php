<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;

class RegisterService
{
    protected $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data, ?string $comingAffiliate = null)
    {
        return $newUser=$this->userRepository->create($data);
    }

 
}