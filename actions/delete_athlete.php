<?php
// actions/delete_athlete.php
// Elimina un deportista y devuelve JSON

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Database.php';

header('Content-Type: application/json');
$db = \App\Database::getConnection();

// 1) Parámetro POST
$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// 2) Ejecutar borrado (cascade eliminará deportista_modalidad)
$stmt = $db->prepare('DELETE FROM deportistas WHERE id = ?');
$stmt->execute([$id]);

// 3) Responder éxito
echo json_encode(['success' => true, 'id' => $id]);
