<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/db.php';

$db = getDb();

// Example: fetch athletes
$stmt = $db->query('SELECT id, name, email FROM athletes');
$athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Club de Patinaje Artístico</title>
</head>
<body>
<h1>Club de Patinaje Artístico</h1>
<p>Bienvenido al sistema de gestión del club.</p>
<h2>Deportistas</h2>
<ul>
<?php foreach ($athletes as $athlete): ?>
<li><?php echo htmlspecialchars($athlete['name']); ?> (<?php echo htmlspecialchars($athlete['email']); ?>)</li>
<?php endforeach; ?>
</ul>
</body>
</html>
