<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Deportistas</h1>
    <p><a class="btn btn-primary" href="?r=athletes/form">Nuevo deportista</a></p>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Email</th>
                <th>Fecha Nac.</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($athletes as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['id']) ?></td>
                    <td><?= htmlspecialchars($a['name']) ?></td>
                    <td><?= htmlspecialchars($a['rut']) ?></td>
                    <td><?= htmlspecialchars($a['email']) ?></td>
                    <td><?= $a['birthdate'] ? htmlspecialchars(date('d-m-Y', strtotime($a['birthdate']))) : '' ?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="?r=athletes/form&id=<?= $a['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="?r=athletes/delete&id=<?= $a['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>