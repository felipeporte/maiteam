<?php
// actions/delete_athlete.php
// Elimina un deportista y devuelve JSON

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/db.php';

header('Content-Type: application/json');
$db = getDb();

// 1) Parámetro POST
$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// 2) Ejecutar borrado (cascade eliminará athlete_modalidad)
$stmt = $db->prepare('DELETE FROM athletes WHERE id = ?');
$stmt->execute([$id]);

// 3) Responder éxito
echo json_encode(['success' => true, 'id' => $id]);
