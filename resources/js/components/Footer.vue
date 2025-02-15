<template>
    <footer class="admin-footer">
        <div class="footer-container">
            <div class="footer-left">
                <p>
                    © 2025 <strong>Task Management System</strong>. All rights
                    reserved.
                </p>
            </div>
            <div class="footer-right">
                <a href="#">Chính sách bảo mật</a>
                <a href="#">Điều khoản sử dụng</a>
                <a href="#">Hỗ trợ</a>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.admin-footer {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    background-color: #3f7a7d;
    color: white;
    padding: 15px 20px;
    font-size: 14px;
    text-align: center;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: auto;
}

.footer-left p {
    margin: 0;
}

.footer-right a {
    color: white;
    text-decoration: none;
    margin-left: 15px;
    transition: 0.3s;
}

.footer-right a:hover {
    text-decoration: underline;
    color: #383737;
}
</style>
