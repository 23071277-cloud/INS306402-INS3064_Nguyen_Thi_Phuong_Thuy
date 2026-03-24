<?php
// Bắt buộc phải khởi tạo session để lưu trữ token
session_start();

// 1. Generate random token: Tạo CSRF token nếu chưa tồn tại trong session
if (empty($_SESSION['csrf_token'])) {
    // Sử dụng random_bytes() để tạo dữ liệu ngẫu nhiên an toàn về mặt mật mã học
    // bin2hex() chuyển đổi dữ liệu nhị phân thành chuỗi hệ thập lục phân dễ đọc
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';

// 2. Verify on every POST request: Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Kiểm tra xem token có được gửi lên từ form hay không
    $postToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    // 3. Fail with 403 Forbidden on mismatch
    // Sử dụng hash_equals() thay vì '===' để ngăn chặn tấn công tính toán thời gian (Timing Attack)
    if (empty($postToken) || !hash_equals($sessionToken, $postToken)) {
        // Thiết lập mã trạng thái HTTP 403
        http_response_code(403);
        // Dừng thực thi kịch bản và in ra thông báo lỗi
        exit('<h2>403 Forbidden</h2><p>Lỗi xác thực CSRF. Yêu cầu đã bị từ chối để bảo vệ hệ thống.</p>');
    }

    // Nếu token hợp lệ, tiếp tục xử lý dữ liệu an toàn
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT);
    if ($amount) {
        $message = "<span style='color: green;'>Chuyển khoản thành công số tiền: " . number_format($amount) . " VNĐ.</span>";
    } else {
        $message = "<span style='color: red;'>Số tiền không hợp lệ.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảo mật CSRF</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { border: 1px solid #ccc; padding: 20px; max-width: 400px; }
    </style>
</head>
<body>

    <h2>Chuyển tiền nội bộ</h2>
    
    <div class="form-container">
        <form method="POST" action="">
            
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            
            <label for="amount">Số tiền cần chuyển (VNĐ):</label><br><br>
            <input type="number" name="amount" id="amount" required min="1000" placeholder="VD: 50000"><br><br>
            
            <button type="submit">Xác nhận chuyển</button>
        </form>
    </div>

    <?php if ($message): ?>
        <p><strong>Trạng thái:</strong> <?php echo $message; ?></p>
    <?php endif; ?>

</body>
</html>