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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h1 class="mb-4">Club de Patinaje Artístico</h1>
<p class="mb-3">Bienvenido al sistema de gestión del club.</p>
<p><a class="btn btn-primary" href="add_athlete.php">Añadir nuevo deportista</a></p>

<h2 class="mt-4">Deportistas</h2>
<ul class="list-group">
<?php foreach ($athletes as $athlete): ?>
<li class="list-group-item">
    <?php echo htmlspecialchars($athlete['name']); ?>
    (<?php echo htmlspecialchars($athlete['email']); ?>)
</li>
<?php endforeach; ?>
</ul>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
