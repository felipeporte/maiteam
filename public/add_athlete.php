<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Database.php';

$db = \App\Database::getConnection();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = $_POST['birthdate'] ?? null;

    if ($name === '') {
        $errors[] = 'El nombre es obligatorio';
    }

    if (!$errors) {
        $stmt = $db->prepare('INSERT INTO athletes (name, email, birthdate) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email ?: null, $birthdate ?: null]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Deportista</title>
    <link href="./../asset/css/custom.css" rel="stylesheet">
</head>
<body class="container py-4">
<h1 class="mb-4">Añadir Deportista</h1>
<?php if ($errors): ?>
    <div class="alert alert-danger" role="alert">
    <ul class="mb-0">
    <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
    <?php endforeach; ?>
    </ul>
    </div>
<?php endif; ?>
<form method="post" class="mb-3">
    <div class="mb-3">
        <label class="form-label">Nombre:
            <input class="form-control" type="text" name="name" required>
        </label>
    </div>
    <div class="mb-3">
        <label class="form-label">Email:
            <input class="form-control" type="email" name="email">
        </label>
    </div>
    <div class="mb-3">
        <label class="form-label">Fecha de Nacimiento:
            <input class="form-control" type="date" name="birthdate">
        </label>
    </div>
    <button class="btn btn-primary" type="submit">Guardar</button>
</form>
<p><a class="btn btn-secondary" href="index.php">Volver al listado</a></p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
