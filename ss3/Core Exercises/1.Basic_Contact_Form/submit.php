<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    echo "<!DOCTYPE html>
    <html>
    <head>
        <style>
            body { 
                font-family: sans-serif; 
                background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
                display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
            }
            .result-card {
                background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                width: 100%; max-width: 400px;
            }
            h3 { color: #e73c7e; text-align: center; }
            ul { list-style: none; padding: 0; }
            li { margin-bottom: 10px; padding: 10px; background: #f9f9f9; border-radius: 5px; }
            .btn-back {
                display: block; width: 100%; text-align: center; padding: 12px; margin-top: 20px;
                background: #23a6d5; color: white; text-decoration: none; border-radius: 10px; font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class='result-card'>";

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "<h3>Lỗi: Thiếu dữ liệu!</h3>
              <p>Vui lòng điền đầy đủ thông tin.</p>
              <a href='javascript:history.back()' class='btn-back'>Quay lại sửa</a>";
    } else {
        echo "<h3>Gửi thành công!</h3>
              <ul>
                <li><strong>Họ tên:</strong> " . htmlspecialchars($name) . "</li>
                <li><strong>Email:</strong> " . htmlspecialchars($email) . "</li>
                <li><strong>SĐT:</strong> " . htmlspecialchars($phone) . "</li>
                <li><strong>Tin nhắn:</strong> " . htmlspecialchars($message) . "</li>
              </ul>
              <a href='contact.html' class='btn-back'>Gửi thêm phản hồi</a>";
    }

    echo "</div></body></html>";
}
?>