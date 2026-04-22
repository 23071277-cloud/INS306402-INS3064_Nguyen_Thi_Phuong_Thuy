<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();
$books = $db->fetchAll('SELECT * FROM books ORDER BY title');

$success = '';
if (isset($_GET['success'])) $success = 'Thêm sách thành công!';
if (isset($_GET['updated'])) $success = 'Cập nhật sách thành công!';
if (isset($_GET['deleted'])) $success = 'Xóa sách thành công!';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sách Thư viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding: 20px; }</style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">📚 Quản lý Sách Thư viện</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-success mb-3">+ Thêm sách mới</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Nhà xuất bản</th>
                <th>Năm XB</th>
                <th>Số bản có sẵn</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['publisher'] ?? 'N/A') ?></td>
                <td><?= $book['publication_year'] ?? 'N/A' ?></td>
                <td><?= $book['available_copies'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="delete.php?id=<?= $book['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Xóa sách này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>