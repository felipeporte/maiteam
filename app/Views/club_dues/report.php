<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Deuda por Apoderado</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Apoderado</th>
                <th>Monto Pendiente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $r): ?>
                <tr class="<?= $r['pending'] > 0 ? 'table-danger' : '' ?>">
                    <td><?= htmlspecialchars($r['guardian']) ?></td>
                    <td><?= number_format($r['pending'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>