<?php
require_once __DIR__.'/../src/db.php';
$db = getDb();
$n = (int)($_GET['nivel_id']??0);
$stmt = $db->prepare("
  SELECT DISTINCT subnivel AS nombre 
    FROM condicionales_categoria 
   WHERE nivel_id = ? 
     AND subnivel IS NOT NULL
");
$stmt->execute([$n]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
