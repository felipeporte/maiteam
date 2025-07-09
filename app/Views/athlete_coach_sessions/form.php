<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($session['id']) ? 'Editar' : 'Nueva' ?> Sesión</h1>
    <form method="post" action="?r=athlete_coach_sessions/save">
        <?php if (isset($session['id'])): ?>
            <input type="hidden" name="id" value="<?= $session['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Deportista:
                <select name="athlete_id" class="form-control" required>
                    <option value="">--Selecciona--</option>
                    <?php foreach ($athletes as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= $a['id'] == ($session['athlete_id'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Coach:
                <select name="coach_id" class="form-control" required>
                    <option value="">--Selecciona--</option>
                    <?php foreach ($coaches as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == ($session['coach_id'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo Entrenamiento:
                <select name="training_type_id" class="form-control">
                    <option value="">--Selecciona--</option>
                    <?php foreach ($trainingTypes as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $t['id'] == ($session['training_type_id'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($t['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Modo Sesión:
                <select name="session_mode" class="form-control">
                    <?php foreach (['zoom'=>'Zoom','presencial'=>'Presencial','flex'=>'Flex'] as $k=>$v): ?>
                        <option value="<?= $k ?>" <?= $k == ($session['session_mode'] ?? '') ? 'selected' : '' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Cuota Mensual:
                <input class="form-control" type="number" step="0.01" name="monthly_fee" value="<?= htmlspecialchars($session['monthly_fee'] ?? '') ?>" required>
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=athlete_coach_sessions/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>