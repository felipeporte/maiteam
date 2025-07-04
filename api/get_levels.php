<?php
require_once __DIR__.'/../src/db.php';
$db = getDb();
$m = (int)($_GET['modalidad_id']??0);
$stmt = $db->prepare("SELECT id,nombre FROM niveles WHERE modalidad_id=?");
$stmt->execute([$m]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
