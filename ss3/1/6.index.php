<?php
// index.php - Front Controller

// 1. Thu thập yêu cầu: Lấy giá trị của 'page' từ URL (ví dụ: ?page=about)
// Nếu không có tham số nào được truyền, mặc định sẽ là trang 'home'
$page = $_GET['page'] ?? 'home';

// 2. Bảo mật: Định nghĩa danh sách trắng (Whitelist) các trang được phép truy cập
// Điều này ngăn chặn tấn công LFI (Local File Inclusion), nơi kẻ xấu cố tình truyền ?page=../../etc/passwd
$allowed_pages = [
    'home',
    'about',
    'contact',
    'services'
];

// 3. Logic Điều hướng (Routing)
// Khởi tạo biến lưu đường dẫn tới file view
$view_file = '';

if (in_array($page, $allowed_pages)) {
    // Nếu trang yêu cầu nằm trong danh sách cho phép, tạo đường dẫn
    $view_file = "views/{$page}.php";
} else {
    // Nếu trang không được phép hoặc người dùng gõ linh tinh, trỏ về trang 404
    $view_file = "views/404.php";
}

// 4. Trình bày (View): Nhúng file HTML tương ứng
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Simple PHP Router</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; color: #333; }
        header { background: #007bff; color: white; padding: 15px 20px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        main { padding: 20px; min-height: 400px; }
        footer { background: #f1f1f1; text-align: center; padding: 10px; border-top: 1px solid #ccc; }
    </style>
</head>
<body>

    <header>
        <nav>
            <a href="index.php?page=home">Trang chủ</a>
            <a href="index.php?page=about">Giới thiệu</a>
            <a href="index.php?page=contact">Liên hệ</a>
            <a href="index.php?page=hidden_page">Trang lỗi (Test 404)</a>
        </nav>
    </header>

    <main>
        <?php
        // Nhúng nội dung file view vào phần chính của trang web
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            // Fallback trong trường hợp file 404.php cũng không tồn tại
            echo "<h2>404 Not Found</h2><p>Trang bạn yêu cầu không tồn tại.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Hệ thống Routing Cơ bản.</p>
    </footer>

</body>
</html>