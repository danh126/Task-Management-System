<?php

namespace App\Repositories;

use App\Interface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers()
    {
        return $this->user->all();
    }

    public function getUser($userId)
    {
        //
    }

    public function createUser()
    {
        //
    }

    public function updateUser($userId, Request $request)
    {
        $user = User::find($userId);
        
        if($user){
            $user->update($request->toArray()); 
            return $user;
        }
    }

    public function deleteUser($userId, Request $request)
    {
        //
    }
}