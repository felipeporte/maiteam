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
    <link href="./../asset/css/custom.css" rel="stylesheet">
</head>
<body class="container py-4">
    <main>
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
<nav class="main-menu">
        <h1>Fitness App</h1>
        <img class="logo" src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/4cfdcb5a-0137-4457-8be1-6e7bd1f29ebb" alt="" />
        <ul>
          <li class="nav-item active">
            <b></b>
            <b></b>
            <a href="#">
              <i class="fa fa-house nav-icon"></i>
              <span class="nav-text">Home</span>
            </a>
          </li>

          <li class="nav-item">
            <b></b>
            <b></b>
            <a href="#">
              <i class="fa fa-user nav-icon"></i>
              <span class="nav-text">Profile</span>
            </a>
          </li>

          <li class="nav-item">
            <b></b>
            <b></b>
            <a href="#">
              <i class="fa fa-calendar-check nav-icon"></i>
              <span class="nav-text">Schedule</span>
            </a>
          </li>

          <li class="nav-item">
            <b></b>
            <b></b>
            <a href="#">
              <i class="fa fa-person-running nav-icon"></i>
              <span class="nav-text">Activities</span>
            </a>
          </li>

          <li class="nav-item">
            <b></b>
            <b></b>
            <a href="#">
              <i class="fa fa-sliders nav-icon"></i>
              <span class="nav-text">Settings</span>
            </a>
          </li>
        </ul>
      </nav>
</main>
</body>
</html>
