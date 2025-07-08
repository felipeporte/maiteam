<?php
namespace App\Models;

use App\Database;
use PDO;

class GuardianAthlete
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $sql = 'SELECT ga.guardian_id, g.name AS guardian, ga.athlete_id, a.name AS athlete
                FROM guardian_athlete ga
                JOIN guardians g ON g.id = ga.guardian_id
                JOIN athletes a ON a.id = ga.athlete_id
                ORDER BY g.name, a.name';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $guardianId, int $athleteId): void
    {
        $stmt = $this->db->prepare('INSERT INTO guardian_athlete (guardian_id, athlete_id) VALUES (?, ?)');
        $stmt->execute([$guardianId, $athleteId]);
    }

    public function delete(int $guardianId, int $athleteId): void
    {
        $stmt = $this->db->prepare('DELETE FROM guardian_athlete WHERE guardian_id=? AND athlete_id=?');
        $stmt->execute([$guardianId, $athleteId]);
    }

    public function guardians(): array
    {
        return $this->db->query('SELECT id, name FROM guardians ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function athletes(): array
    {
        return $this->db->query('SELECT id, name FROM athletes ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }
}