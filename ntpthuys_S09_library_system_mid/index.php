<?php
// index.php - Trang chủ Dashboard
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện Đại học - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 40px 20px; background: #f8f9fa; }
        .card { transition: all 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-5">📚 HỆ THỐNG QUẢN LÝ THƯ VIỆN</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card text-center p-4">
                <h3>📖 Quản lý Sách</h3>
                <p class="text-muted">Thêm, sửa, xóa và xem danh sách sách trong thư viện</p>
                <a href="books/index.php" class="btn btn-primary btn-lg w-100">Truy cập Quản lý Sách</a>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="text-muted">Exam 3 - Library Book Borrowing Management System</p>
        <small>Chỉ thực hiện CRUD trên bảng <strong>books</strong> (theo yêu cầu đề thi)</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>