<?php

namespace App\Http\Controllers;

use App\Interface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->getUsers();
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->createUser($request);

        return response([
            'user' => $user
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $user = $this->userRepository->updateUser($id, $request);

        return response([
            'user' => $user
        ]);
    }

    public function destroy(string $id)
    {
        $user = $this->userRepository->deleteUser($id);

        return response([
            'result' => $user
        ]);
    }

    public function getManagers()
    {
        $managers = $this->userRepository->getListManagers();

        return response([
            'managers' => $managers
        ]);
    }

    public function getEmployees()
    {
        $employees = $this->userRepository->getListEmployees();

        return response([
            'employees' => $employees
        ]);
    }

    public function changePassword ($userId, Request $request)
    {
        $user = $this->userRepository->changePassword($userId, $request);

        return response([
            'user' => $user
        ]);
    }
}
