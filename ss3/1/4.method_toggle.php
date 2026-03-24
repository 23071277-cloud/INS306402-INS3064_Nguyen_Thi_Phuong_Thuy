<?php
// Controller: Xác định phương thức của HTTP Request hiện tại
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Khởi tạo mảng để chứa dữ liệu nhận được
$submittedData = [];
$superglobalName = '';

// Dựa vào phương thức, chọn mảng siêu toàn cục (Superglobal Array) thích hợp
if ($requestMethod === 'POST') {
    $submittedData = $_POST;
    $superglobalName = '$_POST';
} elseif ($requestMethod === 'GET' && !empty($_GET)) {
    // Chỉ lấy dữ liệu GET nếu mảng không rỗng (tránh in ra khi trang vừa tải lần đầu)
    $submittedData = $_GET;
    $superglobalName = '$_GET';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>GET vs POST Toggle</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; color: #333; }
        .container { display: flex; gap: 20px; flex-wrap: wrap; }
        .panel { border: 1px solid #ccc; padding: 20px; flex: 1; min-width: 300px; background: #fafafa; }
        pre { background: #272822; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 14px; }
        .badge { display: inline-block; padding: 5px 10px; color: white; font-weight: bold; border-radius: 4px; }
        .badge.get { background-color: #007bff; }
        .badge.post { background-color: #28a745; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 15px; box-sizing: border-box; }
        button { padding: 10px 15px; margin-right: 10px; cursor: pointer; border: none; border-radius: 4px; color: white; font-weight: bold; }
        button[formmethod="get"] { background-color: #007bff; }
        button[formmethod="post"] { background-color: #28a745; }
        button:hover { opacity: 0.9; }
    </style>
</head>
<body>

    <h2>Minh họa Truyền dữ liệu: GET và POST</h2>
    
    <div class="container">
        <div class="panel">
            <h3>Form Nhập liệu</h3>
            <form action="">
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" value="linhnguyencute08">
                
                <label for="role">Vai trò:</label>
                <input type="text" id="role" name="role" value="Developer">
                
                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                
                <button type="submit" formmethod="get">Gửi bằng GET</button>
                <button type="submit" formmethod="post">Gửi bằng POST</button>
            </form>
            <p style="font-size: 0.85em; color: #666; margin-top: 15px;">
                <em>Lưu ý: Khi bấm "Gửi bằng GET", hãy quan sát sự thay đổi trên thanh URL của trình duyệt. Dữ liệu POST sẽ được gửi ngầm.</em>
            </p>
        </div>

        <div class="panel">
            <h3>Kết quả Server Nhận được</h3>
            <p>
                Phương thức hiện tại (REQUEST_METHOD): 
                <span class="badge <?php echo strtolower($requestMethod); ?>">
                    <?php echo htmlspecialchars($requestMethod); ?>
                </span>
            </p>

            <?php if (!empty($submittedData)): ?>
                <p>Nội dung mảng <strong><?php echo $superglobalName; ?></strong>:</p>
                <pre><?php print_r($submittedData); ?></pre>
            <?php else: ?>
                <p style="color: #777; font-style: italic;">Chưa có dữ liệu nào được gửi, hoặc trang vừa được tải lần đầu.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>