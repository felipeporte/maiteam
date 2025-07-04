<?php
namespace App\Models;

use App\Database;
use PDO;

class Athlete
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM deportistas ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM deportistas WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO deportistas (name, rut, email, birthdate) VALUES (?,?,?,?)');
        $stmt->execute([
            $data['name'],
            $data['rut'] ?? null,
            $data['email'] ?? null,
            $data['birthdate'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE deportistas SET name=?, rut=?, email=?, birthdate=? WHERE id=?');
        $stmt->execute([
            $data['name'],
            $data['rut'] ?? null,
            $data['email'] ?? null,
            $data['birthdate'] ?? null,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM deportistas WHERE id=?');
        $stmt->execute([$id]);
    }
}
