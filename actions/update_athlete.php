<?php
// actions/update_athlete.php
// Actualiza datos del deportista, múltiples modalidades y recalcula categoría global

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Database.php';

header('Content-Type: application/json');
$db = \App\Database::getConnection();

// 1) Recoger datos POST
$id           = (int) ($_POST['id']            ?? 0);
$name         = trim( $_POST['name']          ?? '');
$rut          = trim( $_POST['rut']           ?? '');
$email        = trim( $_POST['email']         ?? '');
$birthdate    =        $_POST['birthdate']    ?? null;
// Arrays de modalidades
$mods         = $_POST['modalidad_id']         ?? [];
$lvls         = $_POST['nivel_id']             ?? [];
$subs         = $_POST['subnivel']             ?? [];

// Validación mínima
if (!$id || $name === '' || count($mods) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// 2) Cargar categoría previa
$stmt = $db->prepare('SELECT categoria_id FROM deportistas WHERE id = ?');
$stmt->execute([$id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);
$oldCategoria = $current['categoria_id'] ?? null;

// 3) Función para calcular edad al 31/12
function edadCompetencia(string $fechaNacimiento): int {
    $hoy     = new DateTime();
    $finAnio = new DateTime($hoy->format('Y') . '-12-31');
    $nac     = new DateTime($fechaNacimiento);
    return $finAnio->diff($nac)->y;
}
$edad = edadCompetencia($birthdate);

// 4) Para cada modalidad, buscar categoría sugerida y hallar el máximo
$maxSuggested = 0;
$sqlCat = "
  SELECT categoria_id
    FROM condicionales_categoria
   WHERE modalidad_id = :mod
     AND nivel_id     = :niv
     AND (subnivel IS NULL OR subnivel = :sub)
     AND :edad BETWEEN edad_min AND edad_max
   LIMIT 1
";
$stmtCat = $db->prepare($sqlCat);

for ($i = 0; $i < count($mods); $i++) {
    $mod = (int)$mods[$i];
    $niv = (int)$lvls[$i];
    $sub = $subs[$i] ?: null;
    // Ejecutar query de categoría
    $stmtCat->execute([
        ':mod'  => $mod,
        ':niv'  => $niv,
        ':sub'  => $sub,
        ':edad' => $edad
    ]);
    $sugg = (int)$stmtCat->fetchColumn();
    if ($sugg > $maxSuggested) {
        $maxSuggested = $sugg;
    }
}

// 5) Elegir categoría final (nunca bajar)
if ($oldCategoria !== null && $oldCategoria > $maxSuggested) {
    $finalCategoria = $oldCategoria;
} else {
    $finalCategoria = $maxSuggested;
}

// 6) Actualizar tabla deportistas
$stmt = $db->prepare("
  UPDATE deportistas
     SET name         = :name,
         rut          = :rut,
         email        = :email,
         birthdate    = :birthdate,
         categoria_id = :cat
   WHERE id = :id
");
$stmt->execute([
  ':name'      => $name,
  ':rut'       => $rut ?: null,
  ':email'     => $email ?: null,
  ':birthdate' => $birthdate ?: null,
  ':cat'       => $finalCategoria ?: null,
  ':id'        => $id
]);

// 7) Actualizar deportista_modalidad: borrar todas y reinsertar
$db->prepare("DELETE FROM deportista_modalidad WHERE deportista_id = ?")
   ->execute([$id]);

$insertMod = $db->prepare("
  INSERT INTO deportista_modalidad
    (deportista_id, modalidad_id, nivel_id, subnivel)
  VALUES (?,?,?,?)
");
for ($i = 0; $i < count($mods); $i++) {
    $mod = (int)$mods[$i];
    $niv = (int)$lvls[$i];
    $sub = $subs[$i] ?: null;
    if ($mod && $niv) {
        $insertMod->execute([$id, $mod, $niv, $sub]);
    }
}

// 8) Respuesta JSON para refrescar UI
echo json_encode([
  'id'                  => $id,
  'name'                => $name,
  'rut'                 => $rut,
  'email'               => $email,
  'birthdate_formatted' => $birthdate ? date('d-m-Y', strtotime($birthdate)) : '',
  'categoria_id'        => $finalCategoria
]);
