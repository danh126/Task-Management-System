<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        // $users = [
        //     [
        //         'name' => 'Thanh Danh',
        //         'email' => 'danhnt@gmail.com',
        //         'email_verified_at' => time(),
        //         'password' => bcrypt('12345678'),
        //         'role' => 'manager'
        //     ],
        //     [
        //         'name' => 'Danh',
        //         'email' => 'danh@gmail.com',
        //         'email_verified_at' => time(),
        //         'password' => bcrypt('12345678'),
        //         'role' => 'employee'
        //     ]
        // ];

        // foreach($users as $user){
        //     User::factory()->create($user);
        // }

        // echo "Insert user success";
        // $this->call([
        //     ProjectSeeder::class
        // ]);
    }
}
