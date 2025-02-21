<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'tranthib@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Lê Văn C',
                'email' => 'levanc@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Phạm Thị D',
                'email' => 'phamthid@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Hoàng Văn E',
                'email' => 'hoangvane@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Đặng Thị F',
                'email' => 'dangthif@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Bùi Văn G',
                'email' => 'buivang@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Võ Thị H',
                'email' => 'vothih@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Ngô Văn I',
                'email' => 'ngovani@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Dương Thị J',
                'email' => 'duongthij@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Lý Văn K',
                'email' => 'lyvank@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Tô Thị L',
                'email' => 'tothil@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Cao Văn M',
                'email' => 'caovanm@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Hà Thị N',
                'email' => 'hathin@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Chu Văn O',
                'email' => 'chuvano@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Đỗ Thị P',
                'email' => 'dothip@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
            [
                'name' => 'Khúc Văn Q',
                'email' => 'khucvanq@gmail.com',
                'email_verified_at' => time(),
                'password' => bcrypt('123456789'),
                'role' => fake()->randomElement(['manager', 'employee'])
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        echo "Insert user success";
    }
}
