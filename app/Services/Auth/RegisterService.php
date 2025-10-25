<?php

namespace App\Services\Auth;

use App\Models\userTron;
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
         $newUser=$this->userRepository->create($data);
        $tron=userTron::where('user_id',0)->first();
        if($tron){
            $tron->user_id=$newUser->id;
            $tron->save();
        }
        return $newUser;

    }

 
}