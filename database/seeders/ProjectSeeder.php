<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 11; $i++) { 
            $startDate = fake()->dateTimeBetween('-1 year', 'now'); // Ngày bắt đầu trong quá khứ
            $endDate = fake()->dateTimeBetween($startDate, '+1 year'); // Ngày kết thúc sau ngày bắt đầu
        
            Project::query()->create([
                'name' => fake()->name(),
                'description' => fake()->text(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'manager_id' => 6
            ]);
        }

        echo "Insert Projects Success";
    }
}
