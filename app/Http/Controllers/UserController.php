<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected  $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Follow User
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request, $id)
    {
        // Find the user to follow
        $userToFollow = $this->userService->find($id);

        // not found
        if (!$userToFollow) {
            return $this->generateNotFoundResponse();
        }

        // Check if the authenticated user is already following the user
        if ($request->user()->following()->where('follows_user_id', $userToFollow->id)->exists()) {
            return $this->generateConflictResponse(['user_id' => 'You are already following this user.']);
        }

        // Follow the user
        $request->user()->following()->syncWithoutDetaching($userToFollow);

        return $this->generateSuccess(['message' => 'You are now following the user']);
    }

    /**
     * Unfollow the user 
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unfollow(Request $request, $id)
    {
        // Find the user to unfollow
        $userToUnfollow = $this->userService->find($id);

        // not found
        if (!$userToUnfollow) {
            return $this->generateNotFoundResponse();
        }

        //Unfollow the user
        $request->user()->following()->detach($userToUnfollow);

        return $this->generateSuccess(['message' => 'You have unfollowed the user']);
    }

    /**
     * Get suggested users to follow
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSuggestedUsers(Request $request)
    {
        $suggestedUsers = $this->userService->getSuggestedUsers();

        return $this->generateSuccess($suggestedUsers);
    }
}
