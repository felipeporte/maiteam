<?php
require_once __DIR__.'/../app/Database.php';
$db = \App\Database::getConnection();
$m = (int)($_GET['modalidad_id']??0);
$stmt = $db->prepare("SELECT id,nombre FROM niveles WHERE modalidad_id=?");
$stmt->execute([$m]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
