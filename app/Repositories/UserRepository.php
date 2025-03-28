<?php

namespace App\Repositories;

use App\Interface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email_verified_at' => now(),
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

    public function changePassword($userId, Request $request)
    {
        $request->validate([
            'old_pass' => ['required', 'max:64'],
            'new_pass' => ['required', 'max:64'],
            'confirm_pass' => ['required', 'same:new_pass']
        ], [
            'old_pass.max' => 'Độ dài mật khẩu tối đa 64 ký tự!',
            'new_pass.max' => 'Độ dài mật khẩu tối đa 64 ký tự!',
            'confirm_pass.same' => 'Mật khẩu xác nhận không khớp!'
        ]);

        $user = $this->user->find($userId);

        if (!Hash::check($request->old_pass, $user->password)) {
            $res = ['check_pass' => 'Mật khẩu cũ không chính xác!'];

            return $res;
        }

        $newPass = bcrypt($request->new_pass);

        $user->password = $newPass;
        $user->save();

        return $user;
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            return $user;
        }

        return null;
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
