<?php require __DIR__ . '/../../config/database.php'; // chỉ để Bootstrap ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sách - Thư viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">📚 Quản lý Sách Thư viện</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Thêm sách thành công!</div>
    <?php elseif (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Cập nhật sách thành công!</div>
    <?php elseif (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Xóa sách thành công!</div>
    <?php endif; ?>

    <a href="index.php?action=create" class="btn btn-success mb-3">+ Thêm sách mới</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>ISBN</th><th>Tên sách</th><th>Tác giả</th>
                <th>Nhà XB</th><th>Năm XB</th><th>Số bản</th><th>Hành động</th>
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
                    <a href="index.php?action=edit&id=<?= $book['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="index.php?action=delete&id=<?= $book['id'] ?>" 
                       onclick="return confirm('Xóa sách này?')" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>