<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Nueva Relación</h1>
    <form method="post" action="?r=guardian_athlete/save">
        <div class="mb-3">
            <label class="form-label">Apoderado:
                <select name="guardian_id" class="form-control" required>
                    <option value="">--Selecciona--</option>
                    <?php foreach ($guardians as $g): ?>
                        <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Deportista:
                <select name="athlete_id" class="form-control" required>
                    <option value="">--Selecciona--</option>
                    <?php foreach ($athletes as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=guardian_athlete/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>