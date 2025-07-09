<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Totales Mensuales</h1>
    <h2 class="h4 mt-4">Por Coach</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Coach</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($byCoach as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['coach']) ?></td>
                    <td><?= '$' . number_format($r['total'], 0, '', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2 class="h4 mt-5">Por Deportista</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Deportista</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($byAthlete as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['athlete']) ?></td>
                    <td><?= '$' . number_format($r['total'], 0, '', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>