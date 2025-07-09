<?php
namespace App\Models;

use App\Database;
use PDO;

class Coach
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM coaches ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM coaches WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO coaches (name, email) VALUES (?, ?)');
        $stmt->execute([
            $data['name'],
            $data['email'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE coaches SET name=?, email=? WHERE id=?');
        $stmt->execute([
            $data['name'],
            $data['email'] ?? null,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM coaches WHERE id=?');
        $stmt->execute([$id]);
    }
}