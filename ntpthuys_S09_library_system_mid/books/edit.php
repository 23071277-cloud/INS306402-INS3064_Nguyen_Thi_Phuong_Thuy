<?php
// books/edit.php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// Lấy thông tin sách hiện tại
try {
    $book = $db->fetch('SELECT * FROM books WHERE id = ?', [$id]);
    if (!$book) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die('Không thể lấy thông tin sách.');
}

$isbn = $book['isbn'];
$title = $book['title'];
$author = $book['author'];
$publisher = $book['publisher'] ?? '';
$publication_year = $book['publication_year'] ?? '';
$available_copies = $book['available_copies'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn              = trim($_POST['isbn'] ?? '');
    $title             = trim($_POST['title'] ?? '');
    $author            = trim($_POST['author'] ?? '');
    $publisher         = trim($_POST['publisher'] ?? '');
    $publication_year  = (int)($_POST['publication_year'] ?? 0);
    $available_copies  = (int)($_POST['available_copies'] ?? 1);

    if ($isbn === '') $errors['isbn'] = 'Vui lòng nhập ISBN.';
    if ($title === '') $errors['title'] = 'Vui lòng nhập tên sách.';
    if ($author === '') $errors['author'] = 'Vui lòng nhập tên tác giả.';
    if ($available_copies < 0) $errors['available_copies'] = 'Số bản sao không hợp lệ.';

    if (empty($errors)) {
        try {
            // Kiểm tra ISBN trùng với sách khác
            $existing = $db->fetch(
                'SELECT id FROM books WHERE isbn = ? AND id <> ?', 
                [$isbn, $id]
            );

            if ($existing) {
                $errors['isbn'] = 'ISBN này đã thuộc về sách khác.';
            } else {
                $db->update('books', [
                    'isbn'              => $isbn,
                    'title'             => $title,
                    'author'            => $author,
                    'publisher'         => $publisher,
                    'publication_year'  => $publication_year > 0 ? $publication_year : null,
                    'available_copies'  => $available_copies
                ], 'id = ?', [$id]);

                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'Có lỗi khi cập nhật sách.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Sửa thông tin sách</h2>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4">
        <!-- Các trường giống create.php -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">ISBN <span class="text-danger">*</span></label>
                <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($isbn) ?>" required>
                <?php if (!empty($errors['isbn'])): ?><span class="text-danger"><?= htmlspecialchars($errors['isbn']) ?></span><?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Số bản có sẵn <span class="text-danger">*</span></label>
                <input type="number" name="available_copies" class="form-control" value="<?= $available_copies ?>" min="0" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên sách <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
            <?php if (!empty($errors['title'])): ?><span class="text-danger"><?= htmlspecialchars($errors['title']) ?></span><?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả <span class="text-danger">*</span></label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($author) ?>" required>
            <?php if (!empty($errors['author'])): ?><span class="text-danger"><?= htmlspecialchars($errors['author']) ?></span><?php endif; ?>
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

        <button type="submit" class="btn btn-primary">Cập nhật sách</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>