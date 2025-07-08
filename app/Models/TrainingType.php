<?php
namespace App\Models;

use App\Database;
use PDO;

class TrainingType
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM training_types ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM training_types WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO training_types (name) VALUES (?)');
        $stmt->execute([
            $data['name'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE training_types SET name=? WHERE id=?');
        $stmt->execute([
            $data['name'],
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM training_types WHERE id=?');
        $stmt->execute([$id]);
    }
}