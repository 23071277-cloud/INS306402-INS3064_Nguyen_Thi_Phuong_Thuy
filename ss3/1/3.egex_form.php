<?php
// Khởi tạo mảng lưu trữ các thông báo lỗi cụ thể
$errors = [];
$success_message = '';
$password_input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập dữ liệu mật khẩu
    $password = $_POST['password'] ?? '';
    $password_input = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    // 1. Kiểm tra độ dài tối thiểu (Thực tiễn tốt, dù không yêu cầu rõ)
    if (strlen($password) < 8) {
        $errors[] = "Mật khẩu phải có ít nhất 8 ký tự.";
    }

    // 2. Kiểm tra chữ cái in hoa
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Mật khẩu thiếu ít nhất 1 chữ cái in hoa (A-Z).";
    }

    // 3. Kiểm tra chữ cái in thường
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Mật khẩu thiếu ít nhất 1 chữ cái in thường (a-z).";
    }

    // 4. Kiểm tra chữ số
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Mật khẩu thiếu ít nhất 1 chữ số (0-9).";
    }

    // 5. Kiểm tra ký tự đặc biệt (\W đại diện cho non-word characters, _ là ngoại lệ cần thêm vào hoặc dùng \W kết hợp)
    // Biểu thức /[^a-zA-Z0-9]/ đảm bảo bắt mọi ký tự không phải chữ và số.
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $errors[] = "Mật khẩu thiếu ít nhất 1 ký tự đặc biệt (ví dụ: !@#$%^&*).";
    }

    // Nếu mảng lỗi rỗng, mật khẩu đạt chuẩn
    if (empty($errors)) {
        $success_message = "Mật khẩu hợp lệ và đáp ứng đủ các tiêu chuẩn bảo mật.";
        // Trong thực tế, đây là bước thực hiện password_hash() trước khi lưu DB.
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kiểm tra Mật khẩu Regex</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { border: 1px solid #ccc; padding: 20px; max-width: 450px; background-color: #fcfcfc; }
        .error-list { color: #d9534f; background-color: #fdf7f7; padding: 10px; border-left: 4px solid #d9534f; margin-bottom: 15px;}
        .success { color: #28a745; font-weight: bold; }
        input[type="password"], input[type="text"] { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
    </style>
</head>
<body>

    <h2>Thiết lập Mật khẩu</h2>
    
    <div class="form-container">
        
        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <strong>Vui lòng khắc phục các vấn đề sau:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($success_message): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="password">Nhập mật khẩu mới:</label>
            <input type="text" name="password" id="password" value="<?php echo $password_input; ?>" required>
            
            <p style="font-size: 0.85em; color: #555;">
                Yêu cầu: Tối thiểu 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.
            </p>
            
            <button type="submit">Kiểm tra tính hợp lệ</button>
        </form>
    </div>

</body>
</html>