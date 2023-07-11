<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    /**
     * @var User
     */
    private User $model;

    /**
     * @param User $User
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Store User
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $eloquent = $this->model->create($data);
        return $eloquent;
    }

    /**
     * Get User
     *
     * @param int $data
     * @return User
     */
    public function find($id)
    {
        $eloquent = $this->model->find($id);
        return $eloquent;
    }

    /**
     * Get suggested user
     *
     * @param integer $limit
     * @return User
     */
    public function getSuggestedUsers(int $limit = 5)
    {
        $currenUserId = Auth::user()->id;

        // Get suggested users (example: random users)
        $suggestedUsers = $this->model->where('id', '!=' , $currenUserId)->inRandomOrder()->take($limit)->get();

        return $suggestedUsers;
    }
}
