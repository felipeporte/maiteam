<?php
namespace App\Models;

use App\Database;
use PDO;

class ClubDue
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $sql = 'SELECT cd.id, cd.amount, cd.due_date, cd.paid_at, g.name AS guardian
                FROM club_dues cd
                JOIN guardians g ON g.id = cd.guardian_id
                ORDER BY cd.due_date DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM club_dues WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO club_dues (guardian_id, amount, due_date, paid_at) VALUES (?,?,?,?)');
        $stmt->execute([
            $data['guardian_id'],
            $data['amount'],
            $data['due_date'] ?? null,
            $data['paid_at'] ?? null
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE club_dues SET guardian_id=?, amount=?, due_date=?, paid_at=? WHERE id=?');
        $stmt->execute([
            $data['guardian_id'],
            $data['amount'],
            $data['due_date'] ?? null,
            $data['paid_at'] ?? null,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM club_dues WHERE id=?');
        $stmt->execute([$id]);
    }

    public function guardians(): array
    {
        return $this->db->query('SELECT id, name FROM guardians ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }
}