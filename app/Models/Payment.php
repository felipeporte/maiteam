<?php
namespace App\Models;

use App\Database;
use PDO;

class Payment
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $sql = 'SELECT p.id, p.amount, p.paid_at,
                       a.name AS athlete, g.name AS guardian, c.name AS coach
                FROM payments p
                LEFT JOIN athletes a ON a.id = p.athlete_id
                LEFT JOIN guardians g ON g.id = p.guardian_id
                LEFT JOIN coaches c ON c.id = p.coach_id
                ORDER BY p.paid_at DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM payments WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO payments (athlete_id, coach_id, guardian_id, amount, paid_at) VALUES (?,?,?,?,?)');
        $stmt->execute([
            $data['athlete_id'] ?: null,
            $data['coach_id'] ?: null,
            $data['guardian_id'] ?: null,
            $data['amount'],
            $data['paid_at'] ?? null
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE payments SET athlete_id=?, coach_id=?, guardian_id=?, amount=?, paid_at=? WHERE id=?');
        $stmt->execute([
            $data['athlete_id'] ?: null,
            $data['coach_id'] ?: null,
            $data['guardian_id'] ?: null,
            $data['amount'],
            $data['paid_at'] ?? null,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM payments WHERE id=?');
        $stmt->execute([$id]);
    }

    public function athletes(): array
    {
        return $this->db->query('SELECT id, name FROM athletes ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardians(): array
    {
        return $this->db->query('SELECT id, name FROM guardians ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function coaches(): array
    {
        return $this->db->query('SELECT id, name FROM coaches ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }
}