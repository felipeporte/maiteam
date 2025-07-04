<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Database.php';

$db = \App\Database::getConnection();
$id = (int)($_GET['id'] ?? 0);

$stmt = $db->prepare('SELECT * FROM deportistas WHERE id = ?');
$stmt->execute([$id]);
$athlete = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$athlete) {
    echo "<p>No se encontró el deportista.</p>";
    exit;
}

// 1) Función para calcular la edad al 31/12 del año actual
function edadCompetencia(string $fechaNacimiento): int
{
    $hoy     = new DateTime();
    $finAnio = new DateTime($hoy->format('Y') . '-12-31');
    $nac     = new DateTime($fechaNacimiento);
    return $finAnio->diff($nac)->y;
}

$edad = edadCompetencia($athlete['birthdate']);

// 2) Consultar modalidades en las que compite el deportista
$sql = "
    SELECT
      dm.modalidad_id,
      m.nombre   AS modalidad,
      dm.nivel_id,
      n.nombre   AS nivel,
      dm.subnivel,
      c.nombre   AS categoria
    FROM deportista_modalidad dm
    JOIN modalidades m ON m.id = dm.modalidad_id
    JOIN niveles     n ON n.id = dm.nivel_id
    LEFT JOIN condicionales_categoria cc
      ON cc.modalidad_id = dm.modalidad_id
     AND cc.nivel_id     = dm.nivel_id
     AND (cc.subnivel IS NULL OR cc.subnivel = dm.subnivel)
     AND :edad BETWEEN cc.edad_min AND cc.edad_max
    LEFT JOIN categorias c ON c.id = cc.categoria_id
    WHERE dm.deportista_id = :id
    ORDER BY m.nombre, n.nombre, dm.subnivel
";
$stmt2 = $db->prepare($sql);
$stmt2->execute([
    ':edad' => $edad,
    ':id'   => $id
]);
$relaciones = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal-body">

    <h4 class="modal-title"><?php echo htmlspecialchars($athlete['name']); ?></h4>

</div>

<ul>
    <li><strong>Rut:</strong> <?php echo htmlspecialchars($athlete['rut']); ?></li>
    <li><strong>Email:</strong> <?php echo htmlspecialchars($athlete['email']); ?></li>
    <li><strong>Fecha de nacimiento:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime($athlete['birthdate']))); ?></li>
    <li><strong>Edad Competencia:</strong> <?php echo $edad; ?> años</li>
</ul>

<?php if ($relaciones): ?>
    <h5>Categorías por modalidad</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Modalidad</th>
                <th>Nivel</th>
                <th>Subnivel</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relaciones as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['modalidad']); ?></td>
                    <td><?php echo htmlspecialchars($r['nivel']); ?></td>
                    <td><?php echo htmlspecialchars($r['subnivel'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($r['categoria'] ?? '—'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Este deportista aún no tiene modalidades asignadas.</p>
<?php endif; ?>