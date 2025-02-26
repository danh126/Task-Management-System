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
        return $this->user->paginate(5);
    }

    public function getUser($userId)
    {
        //
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', 'max:10']
        ], [
            'email.email' => 'Vui lòng nhập đúng định dạng Email!',
            'email.unique' => 'Email đã tồn tại trong hệ thống!'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('123456789'),
            'email_verified_at' => time(),
            'role' => $request->role
        ]);

        return $user;
    }

    public function updateUser($userId, Request $request)
    {
        $user = User::find($userId);

        if ($user) {
            $user->update($request->toArray());
            return $user;
        }
    }

    public function deleteUser($userId)
    {
        $user = User::where('id', $userId)->delete();
        return $user;
    }

    public function getListManagers()
    {
        $managers = $this->user->where('role', 'manager')->get();
        return $managers;
    }

    public function getListEmployees()
    {
        $employees = $this->user->where('role', 'employee')->get();
        return $employees;
    }
}
