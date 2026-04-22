<?php
// books/create.php
require_once __DIR__ . '/../classes/Database.php';

$errors = [];
$isbn = $title = $author = $publisher = '';
$publication_year = '';
$available_copies = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn              = trim($_POST['isbn'] ?? '');
    $title             = trim($_POST['title'] ?? '');
    $author            = trim($_POST['author'] ?? '');
    $publisher         = trim($_POST['publisher'] ?? '');
    $publication_year  = (int)($_POST['publication_year'] ?? 0);
    $available_copies  = (int)($_POST['available_copies'] ?? 1);

    // Validation
    if ($isbn === '') {
        $errors['isbn'] = 'Vui lòng nhập ISBN.';
    }
    if ($title === '') {
        $errors['title'] = 'Vui lòng nhập tên sách.';
    }
    if ($author === '') {
        $errors['author'] = 'Vui lòng nhập tên tác giả.';
    }
    if ($available_copies < 0) {
        $errors['available_copies'] = 'Số bản sao phải lớn hơn hoặc bằng 0.';
    }

    if (empty($errors)) {
        try {
            $db = Database::getInstance();

            // Kiểm tra ISBN đã tồn tại chưa
            $existing = $db->fetch('SELECT id FROM books WHERE isbn = ?', [$isbn]);
            if ($existing) {
                $errors['isbn'] = 'ISBN này đã tồn tại trong hệ thống.';
            } else {
                $db->insert('books', [
                    'isbn'              => $isbn,
                    'title'             => $title,
                    'author'            => $author,
                    'publisher'         => $publisher,
                    'publication_year'  => $publication_year > 0 ? $publication_year : null,
                    'available_copies'  => $available_copies
                ]);

                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'Có lỗi xảy ra khi thêm sách. Vui lòng thử lại.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Thêm sách mới</h2>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">ISBN <span class="text-danger">*</span></label>
                <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($isbn) ?>" required>
                <?php if (!empty($errors['isbn'])): ?>
                    <span class="text-danger"><?= htmlspecialchars($errors['isbn']) ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Số bản có sẵn <span class="text-danger">*</span></label>
                <input type="number" name="available_copies" class="form-control" value="<?= $available_copies ?>" min="0" required>
                <?php if (!empty($errors['available_copies'])): ?>
                    <span class="text-danger"><?= htmlspecialchars($errors['available_copies']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên sách <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
            <?php if (!empty($errors['title'])): ?>
                <span class="text-danger"><?= htmlspecialchars($errors['title']) ?></span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả <span class="text-danger">*</span></label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($author) ?>" required>
            <?php if (!empty($errors['author'])): ?>
                <span class="text-danger"><?= htmlspecialchars($errors['author']) ?></span>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nhà xuất bản</label>
                <input type="text" name="publisher" class="form-control" value="<?= htmlspecialchars($publisher) ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Năm xuất bản</label>
                <input type="number" name="publication_year" class="form-control" value="<?= $publication_year ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm sách</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>