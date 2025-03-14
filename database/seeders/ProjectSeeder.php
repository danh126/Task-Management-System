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
        $startDate = fake()->dateTimeBetween('-1 year', 'now'); // Ngày bắt đầu trong quá khứ
        $endDate = fake()->dateTimeBetween($startDate, '+1 year'); // Ngày kết thúc sau ngày bắt đầu

        $projects = [
            [
                'name' => 'Nâng cấp website bán hàng',
                'description' => 'Cải thiện giao diện và tối ưu hiệu suất website bán hàng trực tuyến.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Xây dựng ứng dụng di động',
                'description' => 'Phát triển ứng dụng mobile hỗ trợ mua sắm và thanh toán trực tuyến.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Hệ thống quản lý nhân sự',
                'description' => 'Xây dựng hệ thống quản lý thông tin nhân viên và chấm công.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Tích hợp thanh toán VNPay',
                'description' => 'Thêm phương thức thanh toán VNPay vào hệ thống bán hàng.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Xây dựng hệ thống CRM',
                'description' => 'Quản lý khách hàng, hợp đồng và tương tác với khách hàng.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Phát triển chatbot hỗ trợ khách hàng',
                'description' => 'Xây dựng chatbot giúp tự động phản hồi và hỗ trợ khách hàng.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Nâng cấp bảo mật hệ thống',
                'description' => 'Cải thiện tính bảo mật và kiểm tra các lỗ hổng bảo mật trong hệ thống.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Tối ưu hóa tốc độ website',
                'description' => 'Giảm thời gian tải trang và cải thiện trải nghiệm người dùng.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Phát triển hệ thống báo cáo tự động',
                'description' => 'Tự động hóa việc tạo báo cáo doanh thu, đơn hàng và hiệu suất.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Nghiên cứu và triển khai AI vào sản phẩm',
                'description' => 'Ứng dụng trí tuệ nhân tạo vào hệ thống để cải thiện hiệu suất và tự động hóa.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Phát triển hệ thống ERP',
                'description' => 'Xây dựng hệ thống quản lý tài nguyên doanh nghiệp để tối ưu quy trình làm việc.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Triển khai hệ thống e-learning',
                'description' => 'Xây dựng nền tảng học trực tuyến với các khóa học và bài kiểm tra.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Phát triển chatbot tư vấn tài chính',
                'description' => 'Xây dựng chatbot giúp người dùng quản lý tài chính cá nhân và đầu tư.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Nâng cấp hệ thống quản lý kho hàng',
                'description' => 'Tối ưu quy trình nhập, xuất và kiểm kê kho bằng công nghệ mới.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Xây dựng ứng dụng đặt lịch hẹn',
                'description' => 'Ứng dụng hỗ trợ khách hàng đặt lịch hẹn với bác sĩ, salon, spa...',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Tích hợp AI vào chăm sóc khách hàng',
                'description' => 'Ứng dụng trí tuệ nhân tạo để phân tích nhu cầu và hỗ trợ khách hàng tốt hơn.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Phát triển nền tảng thương mại điện tử B2B',
                'description' => 'Tạo sàn giao dịch trực tuyến cho doanh nghiệp mua bán hàng hóa và dịch vụ.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Xây dựng hệ thống chấm công bằng vân tay',
                'description' => 'Triển khai hệ thống chấm công hiện đại giúp doanh nghiệp quản lý nhân sự hiệu quả.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Nâng cấp giao diện người dùng cho app di động',
                'description' => 'Tối ưu trải nghiệm người dùng bằng UI/UX hiện đại và dễ sử dụng hơn.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
            [
                'name' => 'Xây dựng nền tảng đặt vé trực tuyến',
                'description' => 'Phát triển hệ thống đặt vé máy bay, tàu xe với nhiều phương thức thanh toán.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                'manager_id' => fake()->randomElement([2, 3])
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->create($project);
        }

        echo "Insert Projects Success";
    }
}
