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
        return $this->db->query('SELECT * FROM athletes ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM athletes WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO athletes (name, rut, email, birthdate) VALUES (?,?,?,?)');
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
        $stmt = $this->db->prepare('UPDATE athletes SET name=?, rut=?, email=?, birthdate=? WHERE id=?');
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
        $stmt = $this->db->prepare('DELETE FROM athletes WHERE id=?');
        $stmt->execute([$id]);
    }

    /**
     * Obtener relaciones modalidad/nivel/subnivel para un deportista
     */
    public function getRelations(int $athleteId): array
    {
        $stmt = $this->db->prepare('SELECT modalidad_id, nivel_id, subnivel FROM deportista_modalidad WHERE deportista_id=? ORDER BY modalidad_id');
        $stmt->execute([$athleteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar todas las modalidades disponibles
     */
    public function getModalidades(): array
    {
        return $this->db
            ->query('SELECT id,nombre FROM modalidades ORDER BY nombre')
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar niveles para una modalidad
     */
    public function getLevels(int $modalidadId): array
    {
        $stmt = $this->db->prepare('SELECT id,nombre FROM niveles WHERE modalidad_id=? ORDER BY nombre');
        $stmt->execute([$modalidadId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar subniveles para un nivel
     */
    public function getSublevels(int $nivelId): array
    {
        $stmt = $this->db->prepare('SELECT DISTINCT subnivel FROM condicionales_categoria WHERE nivel_id=? AND subnivel IS NOT NULL ORDER BY subnivel');
        $stmt->execute([$nivelId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Crear o actualizar un deportista junto con su ficha (modalidades y categoría)
     */
    public function saveFicha(?int $id, array $data, array $mods, array $lvls, array $subs): int
    {
        // Si no existe ID creamos primero el deportista
        if (!$id) {
            $id = $this->create($data);
        }

        // Categoría previa
        $stmt = $this->db->prepare('SELECT categoria_id FROM athletes WHERE id = ?');
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $oldCategoria = $current['categoria_id'] ?? null;

        // Calcular edad al 31/12
        $edad = $this->edadCompetencia($data['birthdate']);

        // Buscar categoría sugerida para cada modalidad
        $maxSuggested = 0;
        $sqlCat = 'SELECT categoria_id FROM condicionales_categoria
                    WHERE modalidad_id = :mod
                      AND nivel_id     = :niv
                      AND (subnivel IS NULL OR subnivel = :sub)
                      AND :edad BETWEEN edad_min AND edad_max
                    LIMIT 1';
        $stmtCat = $this->db->prepare($sqlCat);
        for ($i = 0; $i < count($mods); $i++) {
            $mod = (int)$mods[$i];
            $niv = (int)$lvls[$i];
            $sub = $subs[$i] ?: null;
            $stmtCat->execute([
                ':mod'  => $mod,
                ':niv'  => $niv,
                ':sub'  => $sub,
                ':edad' => $edad,
            ]);
            $sugg = (int)$stmtCat->fetchColumn();
            if ($sugg > $maxSuggested) {
                $maxSuggested = $sugg;
            }
        }

        $finalCategoria = ($oldCategoria !== null && $oldCategoria > $maxSuggested)
            ? $oldCategoria
            : $maxSuggested;

        // Actualizar datos del deportista
        $stmt = $this->db->prepare('UPDATE athletes SET name=?, rut=?, email=?, birthdate=?, categoria_id=? WHERE id=?');
        $stmt->execute([
            $data['name'],
            $data['rut'] ?: null,
            $data['email'] ?: null,
            $data['birthdate'] ?: null,
            $finalCategoria ?: null,
            $id,
        ]);

        // Actualizar relaciones modalidad/nivel
        $this->db->prepare('DELETE FROM deportista_modalidad WHERE deportista_id=?')
            ->execute([$id]);
        $insert = $this->db->prepare('INSERT INTO deportista_modalidad (deportista_id, modalidad_id, nivel_id, subnivel) VALUES (?,?,?,?)');
        for ($i = 0; $i < count($mods); $i++) {
            $mod = (int)$mods[$i];
            $niv = (int)$lvls[$i];
            $sub = $subs[$i] ?: null;
            if ($mod && $niv) {
                $insert->execute([$id, $mod, $niv, $sub]);
            }
        }

        return $id;
    }

    private function edadCompetencia(?string $fechaNacimiento): int
    {
        if (!$fechaNacimiento) return 0;
        $hoy     = new \DateTime();
        $finAnio = new \DateTime($hoy->format('Y') . '-12-31');
        $nac     = new \DateTime($fechaNacimiento);
        return $finAnio->diff($nac)->y;
    }
}
