<?php
session_start();

// 1. Khởi tạo biến đếm nếu chưa có
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

$message = "";
$messageClass = "";

// 2. Xử lý logic khi nhấn nút Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Hardcoded credentials
    if ($username === "admin" && $password === "123456") {
        $message = "Đăng nhập thành công! Chào mừng Admin.";
        $messageClass = "success";
        $_SESSION['attempts'] = 0; // Reset lại số lần sai khi thành công
    } else {
        $_SESSION['attempts']++;
        $message = "Thông tin đăng nhập không chính xác!";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Đăng nhập</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
        }
        .login-card {
            background: white; padding: 40px; border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 350px;
        }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input {
            width: 100%; padding: 12px; border: 1px solid #ddd;
            border-radius: 8px; box-sizing: border-box;
        }
        
        button {
            width: 100%; padding: 12px; background: #764ba2; color: white;
            border: none; border-radius: 8px; cursor: pointer;
            font-size: 16px; font-weight: bold; margin-top: 10px;
        }
        button:hover { background: #5a377d; }

        .status-msg {
            padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .counter { text-align: center; margin-top: 15px; color: #666; font-style: italic; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>LOGIN</h2>

    <?php if ($message): ?>
        <div class="status-msg <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="user" placeholder="admin" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" placeholder="123456" required>
        </div>
        <button type="submit">Đăng nhập</button>
    </form>

    <div class="counter">
        Số lần đăng nhập sai: <strong><?php echo $_SESSION['attempts']; ?></strong>
    </div>
</div>

</body>
</html>