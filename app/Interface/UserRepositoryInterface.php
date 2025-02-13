<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getUsers();
    public function getUser($userId);
    public function createUser();
    public function updateUser($userId, Request $request);
    public function deleteUser($userId, Request $request);
}
