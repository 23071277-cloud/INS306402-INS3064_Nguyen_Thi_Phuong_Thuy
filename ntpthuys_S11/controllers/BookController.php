<?php
// controllers/BookController.php
require_once __DIR__ . '/../models/BookModel.php';

class BookController {
    private BookModel $model;

    public function __construct() {
        $this->model = new BookModel();
    }

    public function index() {
        $books = $this->model->getAll();
        require __DIR__ . '/../views/books/index.php';
    }

    public function create() {
        $errors = [];
        $data = [];
        require __DIR__ . '/../views/books/create.php';
    }

    public function store() {
        $data = [
            'isbn'              => trim($_POST['isbn'] ?? ''),
            'title'             => trim($_POST['title'] ?? ''),
            'author'            => trim($_POST['author'] ?? ''),
            'publisher'         => trim($_POST['publisher'] ?? ''),
            'publication_year'  => (int)($_POST['publication_year'] ?? 0),
            'available_copies'  => (int)($_POST['available_copies'] ?? 1)
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            require __DIR__ . '/../views/books/create.php';
            return;
        }

        $this->model->create($data);
        header("Location: index.php?action=index&success=1");
        exit;
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $book = $this->model->getById($id);
        if (!$book) {
            header("Location: index.php?action=index");
            exit;
        }
        $data = $book;
        $errors = [];
        require __DIR__ . '/../views/books/edit.php';
    }

    public function update() {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'isbn'              => trim($_POST['isbn'] ?? ''),
            'title'             => trim($_POST['title'] ?? ''),
            'author'            => trim($_POST['author'] ?? ''),
            'publisher'         => trim($_POST['publisher'] ?? ''),
            'publication_year'  => (int)($_POST['publication_year'] ?? 0),
            'available_copies'  => (int)($_POST['available_copies'] ?? 1)
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $book = $data; // giữ lại dữ liệu form
            require __DIR__ . '/../views/books/edit.php';
            return;
        }

        $this->model->update($id, $data);
        header("Location: index.php?action=index&updated=1");
        exit;
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $this->model->delete($id);
        header("Location: index.php?action=index&deleted=1");
        exit;
    }

    private function validate(array $data): array {
        $errors = [];
        if (empty($data['isbn'])) $errors['isbn'] = 'ISBN không được để trống';
        if (empty($data['title'])) $errors['title'] = 'Tên sách không được để trống';
        if (empty($data['author'])) $errors['author'] = 'Tác giả không được để trống';
        if ($data['available_copies'] < 0) $errors['available_copies'] = 'Số bản sao không hợp lệ';
        return $errors;
    }
}