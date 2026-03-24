<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    // Thư mục lưu trữ file (đảm bảo thư mục này có quyền ghi - write permissions)
    $uploadDir = 'uploads/';
    
    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $file = $_FILES['avatar'];
    $fileTmpName = $file['tmp_name'];
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // 1. Kiểm tra lỗi upload từ server
    if ($fileError === UPLOAD_ERR_OK) {
        
        // 2. Strict Size Validation: Giới hạn tối đa 2MB (2 * 1024 * 1024 bytes)
        $maxSize = 2097152; 
        if ($fileSize <= $maxSize) {
            
            // 3. Strict MIME Type Validation: Đọc file thực tế, KHÔNG tin tưởng $file['type']
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $fileTmpName);
            finfo_close($finfo);

            $allowedMimeTypes = ['image/jpeg', 'image/png'];

            if (in_array($mimeType, $allowedMimeTypes)) {
                
                // 4. Rename File: Đổi tên file để tránh ghi đè và loại bỏ ký tự độc hại
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                // Tạo tên mới dựa trên thời gian thực và chuỗi ngẫu nhiên
                $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
                $destination = $uploadDir . $newFileName;

                // 5. Di chuyển file từ thư mục tạm (tmp) sang thư mục đích
                if (move_uploaded_file($fileTmpName, $destination)) {
                    $message = "<span style='color: green;'>Tải lên thành công! File: $newFileName</span>";
                } else {
                    $message = "<span style='color: red;'>Lỗi hệ thống: Không thể lưu file.</span>";
                }
            } else {
                $message = "<span style='color: red;'>Định dạng không hợp lệ. Chỉ chấp nhận tệp JPG hoặc PNG.</span>";
            }
        } else {
            $message = "<span style='color: red;'>Dung lượng file vượt quá giới hạn 2MB.</span>";
        }
    } else {
        // Xử lý các mã lỗi upload của PHP (ví dụ: file lớn hơn upload_max_filesize trong php.ini)
        $message = "<span style='color: red;'>Quá trình tải lên thất bại. Mã lỗi: $fileError</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Secure Avatar Upload</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .upload-form { border: 1px solid #ccc; padding: 20px; max-width: 400px; }
    </style>
</head>
<body>

    <h2>Tải lên Ảnh đại diện</h2>
    
    <div class="upload-form">
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="avatar">Chọn ảnh (JPG, PNG - Tối đa 2MB):</label><br><br>
            <input type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" required><br><br>
            <button type="submit">Tải lên</button>
        </form>
    </div>

    <?php if ($message): ?>
        <p><strong>Thông báo:</strong> <?php echo $message; ?></p>
    <?php endif; ?>

</body>
</html>