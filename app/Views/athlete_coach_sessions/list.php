<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Sesiones Deportista-Coach</h1>
    <p>
        <a class="btn btn-primary" href="?r=athlete_coach_sessions/form">Nueva sesión</a>
        <a class="btn btn-secondary" href="?r=athlete_coach_sessions/report">Reporte</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>Deportista</th>
                <th>Coach</th>
                <th>Tipo</th>
                <th>Modo</th>
                <th>Monto</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sessions as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['athlete']) ?></td>
                    <td><?= htmlspecialchars($s['coach']) ?></td>
                    <td><?= htmlspecialchars($s['training_type'] ?? '') ?></td>
                    <td><?= htmlspecialchars($s['session_mode']) ?></td>
                    <td><?= number_format($s['monthly_fee'], 0, '', '.') ?></td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="?r=athlete_coach_sessions/form&id=<?= $s['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="?r=athlete_coach_sessions/delete&id=<?= $s['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>