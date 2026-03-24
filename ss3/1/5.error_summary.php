<?php
// Khởi tạo mảng lưu lỗi và mảng lưu dữ liệu đã nhập (để làm Sticky Form)
$errors = [];
$data = [
    'fullname' => '',
    'email' => '',
    'course' => ''
];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập và làm sạch dữ liệu
    $data['fullname'] = trim($_POST['fullname'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['course'] = trim($_POST['course'] ?? '');

    // 1. Kiểm tra từng trường và gán lỗi vào mảng (Sử dụng key là tên trường)
    if (empty($data['fullname'])) {
        $errors['fullname'] = 'Họ và tên không được để trống.';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'Email không được để trống.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Định dạng email không hợp lệ.';
    }

    if (empty($data['course'])) {
        $errors['course'] = 'Vui lòng chọn khóa học bạn muốn đăng ký.';
    }

    // Nếu mảng errors rỗng, form hợp lệ
    if (empty($errors)) {
        $success = true;
        // Thực hiện lưu vào CSDL cho hệ thống LMS tại đây...
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Error Summary Block</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .form-container { max-width: 500px; padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9; }
        
        /* CSS cho Error Summary Block */
        .error-summary {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
        .error-summary ul { margin: 0; padding-left: 20px; }
        
        /* CSS cho Highlight Invalid Fields */
        .input-error { border: 2px solid #dc3545 !important; background-color: #fff8f8; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], select { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        .success-msg { color: #155724; background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 4px; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Đăng ký Hệ thống Học trực tuyến (LMS)</h2>
    
    <div class="form-container">
        
        <?php if ($success): ?>
            <div class="success-msg">
                Đăng ký thành công! Chào mừng <strong><?php echo htmlspecialchars($data['fullname']); ?></strong>.
            </div>
        <?php else: ?>

            <?php if (!empty($errors)): ?>
                <div class="error-summary">
                    <strong>Vui lòng sửa các lỗi sau để tiếp tục:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="fullname">Họ và tên:</label>
                    <input type="text" 
                           id="fullname" 
                           name="fullname" 
                           placeholder="Ví dụ: Nguyễn Thị Thùy Linh"
                           value="<?php echo htmlspecialchars($data['fullname']); ?>"
                           class="<?php echo isset($errors['fullname']) ? 'input-error' : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email liên hệ:</label>
                    <input type="text" 
                           id="email" 
                           name="email" 
                           value="<?php echo htmlspecialchars($data['email']); ?>"
                           class="<?php echo isset($errors['email']) ? 'input-error' : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="course">Khóa học:</label>
                    <select id="course" name="course" class="<?php echo isset($errors['course']) ? 'input-error' : ''; ?>">
                        <option value="">-- Chọn khóa học --</option>
                        <option value="php" <?php echo $data['course'] === 'php' ? 'selected' : ''; ?>>Lập trình PHP Cơ bản</option>
                        <option value="python" <?php echo $data['course'] === 'python' ? 'selected' : ''; ?>>Python cho Data Science</option>
                        <option value="pm" <?php echo $data['course'] === 'pm' ? 'selected' : ''; ?>>Quản lý Dự án (Project Management)</option>
                    </select>
                </div>

                <button type="submit">Gửi đăng ký</button>
            </form>
        
        <?php endif; ?>
    </div>

</body>
</html>