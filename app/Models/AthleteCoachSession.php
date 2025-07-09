<?php
namespace App\Models;

use App\Database;
use PDO;

class AthleteCoachSession
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $sql = 'SELECT s.id, a.name AS athlete, c.name AS coach,
                       tt.name AS training_type, s.session_mode, s.monthly_fee
                FROM athlete_coach_sessions s
                JOIN athletes a ON a.id = s.athlete_id
                JOIN coaches c ON c.id = s.coach_id
                LEFT JOIN training_types tt ON tt.id = s.training_type_id
                ORDER BY a.name, c.name';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM athlete_coach_sessions WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO athlete_coach_sessions (athlete_id, coach_id, training_type_id, session_mode, monthly_fee) VALUES (?,?,?,?,?)');
        $stmt->execute([
            $data['athlete_id'],
            $data['coach_id'],
            $data['training_type_id'] ?: null,
            $data['session_mode'],
            $data['monthly_fee'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE athlete_coach_sessions SET athlete_id=?, coach_id=?, training_type_id=?, session_mode=?, monthly_fee=? WHERE id=?');
        $stmt->execute([
            $data['athlete_id'],
            $data['coach_id'],
            $data['training_type_id'] ?: null,
            $data['session_mode'],
            $data['monthly_fee'],
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM athlete_coach_sessions WHERE id=?');
        $stmt->execute([$id]);
    }

    public function athletes(): array
    {
        return $this->db->query('SELECT id, name FROM athletes ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function coaches(): array
    {
        return $this->db->query('SELECT id, name FROM coaches ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function trainingTypes(): array
    {
        return $this->db->query('SELECT id, name FROM training_types ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function summaryByCoach(): array
    {
        $sql = 'SELECT c.name AS coach, SUM(s.monthly_fee) AS total
                FROM athlete_coach_sessions s
                JOIN coaches c ON c.id = s.coach_id
                GROUP BY c.id
                ORDER BY c.name';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function summaryByAthlete(): array
    {
        $sql = 'SELECT a.name AS athlete, SUM(s.monthly_fee) AS total
                FROM athlete_coach_sessions s
                JOIN athletes a ON a.id = s.athlete_id
                GROUP BY a.id
                ORDER BY a.name';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}