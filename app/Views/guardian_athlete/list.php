<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Relación Apoderado - Deportista</h1>
    <p><a class="btn btn-primary" href="?r=guardian_athlete/form">Nueva relación</a></p>
    <table class="table">
        <thead>
            <tr>
                <th>Apoderado</th>
                <th>Deportista</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relations as $rel): ?>
                <tr>
                    <td><?= htmlspecialchars($rel['guardian']) ?></td>
                    <td><?= htmlspecialchars($rel['athlete']) ?></td>
                    <td>
                        <a class="btn btn-sm btn-danger" href="?r=guardian_athlete/delete&g=<?= $rel['guardian_id'] ?>&a=<?= $rel['athlete_id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>