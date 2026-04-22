<?php
// books/delete.php
require_once __DIR__ . '/../classes/Database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = Database::getInstance();
    $db->delete('books', 'id = ?', [$id]); 
    header('Location: index.php?deleted=1');
    exit;
} catch (Exception $e) {
    // Có thể redirect với thông báo lỗi nếu muốn
    header('Location: index.php');
    exit;
}