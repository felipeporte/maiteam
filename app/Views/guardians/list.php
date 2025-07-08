<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Apoderados</h1>
    <p><a class="btn btn-primary" href="?r=guardians/form">Nuevo apoderado</a></p>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guardians as $g): ?>
                <tr>
                    <td><?= htmlspecialchars($g['id']) ?></td>
                    <td><?= htmlspecialchars($g['name']) ?></td>
                    <td><?= htmlspecialchars($g['email']) ?></td>
                    <td><?= htmlspecialchars($g['phone']) ?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="?r=guardians/form&id=<?= $g['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="?r=guardians/delete&id=<?= $g['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>