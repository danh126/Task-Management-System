# Hệ Thống Quản Lý Công Việc (Task Management System)

## 📌 1. Giới Thiệu

Hệ thống giúp người dùng quản lý công việc, theo dõi tiến độ và phân công nhiệm vụ trong nhóm.  
Hỗ trợ sắp xếp công việc theo các trạng thái **To-Do, In Progress, Done** và cập nhật trạng thái theo thời gian thực.

---

## 🛠 2. Công Nghệ Sử Dụng

| Thành Phần         | Công Nghệ        |
| ------------------ | ---------------- |
| **Backend**        | Laravel 11 (API) |
| **Frontend**       | Vue.js 3 (SPA)   |
| **Database**       | MySQL            |
| **Authentication** | Laravel Breeze   |
| **Realtime**       | Pusher/WebSocket |
| **UI/UX**          | Bootstrap        |
| **Drag & Drop**    | Vue Draggable    |

---

## ✨ 3. Chức Năng Chính

### 🔹 A. Quản Lý Người Dùng & Phân Quyền

-   Đăng ký, đăng nhập, quên mật khẩu (Laravel Breeze).
-   Phân quyền: **Admin, Leader, Member**.

### 🔹 B. Quản Lý Dự Án (Projects)

-   Tạo, sửa, xóa dự án.
-   Mỗi dự án có nhiều danh sách công việc.

### 🔹 C. Quản Lý Công Việc (Tasks)

-   Thêm, chỉnh sửa, xóa công việc.
-   Gán công việc cho nhân viên.
-   Đặt **deadline, mức độ ưu tiên** (Thấp, Trung bình, Cao).
-   Cập nhật trạng thái công việc bằng **Drag & Drop**:
    -   **To-Do** → **In Progress** → **Done**.
-   Thêm ghi chú, bình luận trong công việc.
-   Đính kèm file (tài liệu, hình ảnh).
-   Nhắc nhở công việc sắp đến hạn qua email.

### 🔹 D. Thông Báo & Realtime

-   **Cập nhật trạng thái công việc real-time** (Pusher/WebSocket).
-   **Gửi email thông báo** khi có công việc mới hoặc thay đổi trạng thái.

### 🔹 E. Thống Kê & Báo Cáo

-   Thống kê số lượng công việc theo trạng thái.
-   Báo cáo hiệu suất làm việc của từng nhân viên.

---

## 🚀 4. Cài Đặt & Chạy Dự Án

### 🔹 Backend (Laravel 11)

1. **Clone dự án:**

```bash
git clone https://github.com/danh126/Task-Management-System.git
cd task-management-system
```

-   Cài đặt các package:

```bash
composer install
```

-   Cấu hình môi trường:

    _Copy file .env.example thành .env:_

```bash
 cp .env.example .env
```

-   Cập nhật thông tin database, Pusher API trong .env.

-   Tạo khóa ứng dụng:

```bash
php artisan key:generate
```

-   Chạy migration và seed dữ liệu:

```bash
php artisan migrate --seed
```

-   Chạy server backend:

```bash
php artisan serve
```

### 🔹 Frontend (Vue.js 3)

-   Cài đặt package:

```bash
npm install
```

-   Chạy ứng dụng:

```bash
npm run dev
```

## 📡 5. Tích Hợp Pusher Realtime

-   Cài đặt Pusher package:

```bash
composer require pusher/pusher-php-server
```

-   Cấu hình .env với thông tin Pusher:

```bash
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

-   Cấu hình broadcasting.php trong Laravel:

```bash
'default' => env('BROADCAST_DRIVER', 'pusher'),

        'connections' => [
        'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
        ],
    ],
],
```

-   Chạy queue worker để xử lý job:

```bash
php artisan queue:work
```

### ⚠️ 6. Ghi Chú

-   Dự án sử dụng Laravel Breeze cho xác thực và phân quyền.
    Hỗ trợ Drag & Drop công việc bằng Vue Draggable.
    Gửi thông báo real-time qua Pusher, gửi email thông báo công việc mới và các thay đổi liên quan.

### 🤝 7. Đóng Góp

-   Nếu bạn muốn đóng góp cho dự án, hãy tạo một pull request hoặc liên hệ qua email: **danhnt126@gmail.com**

### 🌟 Cảm ơn bạn đã quan tâm đến dự án! 🚀
