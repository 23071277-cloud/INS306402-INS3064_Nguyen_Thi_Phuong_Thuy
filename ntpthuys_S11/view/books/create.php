<?php require __DIR__ . '/../../config/database.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Thêm sách mới</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err): echo "<div>$err</div>"; endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=store" class="card p-4">
        <!-- Các input giống create.php cũ -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>ISBN <span class="text-danger">*</span></label>
                <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($data['isbn'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Số bản <span class="text-danger">*</span></label>
                <input type="number" name="available_copies" class="form-control" value="<?= $data['available_copies'] ?? 1 ?>" min="0" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Tên sách <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Tác giả <span class="text-danger">*</span></label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($data['author'] ?? '') ?>" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nhà xuất bản</label>
                <input type="text" name="publisher" class="form-control" value="<?= htmlspecialchars($data['publisher'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label>Năm xuất bản</label>
                <input type="number" name="publication_year" class="form-control" value="<?= $data['publication_year'] ?? '' ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Thêm sách</button>
        <a href="index.php?action=index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>