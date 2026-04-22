<?php
// models/BookModel.php
require_once __DIR__ . '/../config/database.php';

class BookModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM books ORDER BY title");
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO books (isbn, title, author, publisher, publication_year, available_copies) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['isbn'], $data['title'], $data['author'],
            $data['publisher'] ?? null, $data['publication_year'] ?? null, $data['available_copies']
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE books 
             SET isbn = ?, title = ?, author = ?, publisher = ?, 
                 publication_year = ?, available_copies = ? 
             WHERE id = ?"
        );
        return $stmt->execute([
            $data['isbn'], $data['title'], $data['author'],
            $data['publisher'] ?? null, $data['publication_year'] ?? null,
            $data['available_copies'], $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}