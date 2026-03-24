<?php
// Khởi tạo các biến để tránh lỗi 'Undefined variable'
$username = '';
$email = '';
$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Thu thập dữ liệu (trong thực tế nên dùng utils.php đã viết ở trên)
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Error Handling (Xử lý lỗi)
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên người dùng.";
    }

    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập địa chỉ email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Định dạng email không hợp lệ.";
    }

    // Nếu mảng errors rỗng nghĩa là không có lỗi
    if (empty($errors)) {
        $success_message = "Dữ liệu hợp lệ! Đang xử lý...";
        // Thường thì sau bước này sẽ lưu vào database và chuyển hướng
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Sticky Forms</title></head>
<body>
    <h2>Đăng ký tài khoản</h2>
    
    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 10px;">
            <label>Tên đăng nhập:</label><br>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <?php if (isset($errors['username'])): ?>
                <span style="color: red; font-size: 0.9em;"><?php echo $errors['username']; ?></span>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (isset($errors['email'])): ?>
                <span style="color: red; font-size: 0.9em;"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>