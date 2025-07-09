<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Cuotas del Club</h1>
    <p>
        <a class="btn btn-primary" href="?r=club_dues/form">Nueva cuota</a>
        <a class="btn btn-info" href="?r=club_dues/report">Reporte de deuda</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>Apoderado</th>
                <th>Monto</th>
                <th>Vencimiento</th>
                <th>Pagado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dues as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['guardian']) ?></td>
                    <td><?= '$' . number_format($d['amount'], 0, '', '.') ?></td>
                    <td><?= $d['due_date'] ?></td>
                    <td><?= $d['paid_at'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="?r=club_dues/form&id=<?= $d['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="?r=club_dues/delete&id=<?= $d['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>