<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/db.php';

$db = getDb();

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
</head>
<body>
<h1>Añadir Deportista</h1>
<?php if ($errors): ?>
    <ul style="color:red;">
    <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="post">
    <label>Nombre:
        <input type="text" name="name" required>
    </label><br>
    <label>Email:
        <input type="email" name="email">
    </label><br>
    <label>Fecha de Nacimiento:
        <input type="date" name="birthdate">
    </label><br>
    <button type="submit">Guardar</button>
</form>
<p><a href="index.php">Volver al listado</a></p>
</body>
</html>
