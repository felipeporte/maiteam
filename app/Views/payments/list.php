<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Pagos a Entrenadores</h1>
    <p><a class="btn btn-primary" href="?r=payments/form">Registrar pago</a></p>
    <table class="table">
        <thead>
            <tr>
                <th>Deportista</th>
                <th>Apoderado</th>
                <th>Coach</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['athlete']) ?></td>
                    <td><?= htmlspecialchars($p['guardian']) ?></td>
                    <td><?= htmlspecialchars($p['coach']) ?></td>
                    <td><?= number_format($p['amount'],2) ?></td>
                    <td><?= $p['paid_at'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="?r=payments/form&id=<?= $p['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="?r=payments/delete&id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>