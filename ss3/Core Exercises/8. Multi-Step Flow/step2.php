<?php
// Flow Control: Kiểm tra xem người dùng có đi từ Bước 1 sang không
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['fullname'])) {
    // Nếu không có dữ liệu, ép quay lại Bước 1
    header('Location: step1.php');
    exit;
}

// Lấy dữ liệu từ Bước 1
$fullname = $_POST['fullname'];
$student_id = $_POST['student_id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head><title>Bước 2 - Hoàn tất</title></head>
<body>
    <h2>Bước 2/2: Thông tin liên hệ</h2>
    <p>Xin chào, <strong><?php echo htmlspecialchars($fullname); ?></strong>. Vui lòng cung cấp thêm thông tin.</p>

    <form method="POST" action="final.php">
        <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

        <label>Số điện thoại:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Địa chỉ:</label><br>
        <input type="text" name="address" required><br><br>

        <button type="submit">Hoàn tất đăng ký</button>
    </form>
</body>
</html>