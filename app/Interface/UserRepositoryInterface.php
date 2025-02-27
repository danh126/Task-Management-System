<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getUsers();
    public function getUser($userId);
    public function createUser(Request $request);
    public function updateUser($userId, Request $request);
    public function changePassword($userId, Request $request);
    public function deleteUser($userId);
    public function getListManagers();
    public function getListEmployees();
}
