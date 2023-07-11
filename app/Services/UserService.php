<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     *  Store User
     * 
     * @return User
     */
    public function create(array $data)
    {        
        return $this->userRepository->create($data);
    }

    /**
     *  Get User by id
     * 
     * @return Boolean
     */
    public function find(int $id)
    {
        return $this->userRepository->find($id);
    }

    /**
     *  Get User token
     * 
     * @return string
     */
    public function getToken()
    {
        $user = Auth::user();
        return $user->createToken('authToken')->plainTextToken;
    }

    /**
     *  Get User By
     * 
     * @return string
     */
    public function getSuggestedUsers()
    {
        return $this->userRepository->getSuggestedUsers();
    }
}
