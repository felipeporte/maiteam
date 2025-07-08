<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($payment['id']) ? 'Editar' : 'Registrar' ?> Pago</h1>
    <form method="post" action="?r=payments/save">
        <?php if (isset($payment['id'])): ?>
            <input type="hidden" name="id" value="<?= $payment['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Deportista:
                <select name="athlete_id" class="form-control">
                    <option value="">--Selecciona--</option>
                    <?php foreach ($athletes as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= $a['id']==($payment['athlete_id']??'') ? 'selected' : '' ?>><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Apoderado:
                <select name="guardian_id" class="form-control">
                    <option value="">--Selecciona--</option>
                    <?php foreach ($guardians as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= $g['id']==($payment['guardian_id']??'') ? 'selected' : '' ?>><?= htmlspecialchars($g['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Coach:
                <select name="coach_id" class="form-control">
                    <option value="">--Selecciona--</option>
                    <?php foreach ($coaches as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id']==($payment['coach_id']??'') ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Monto:
                <input class="form-control" type="number" step="0.01" name="amount" value="<?= htmlspecialchars($payment['amount'] ?? '') ?>" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha:
                <input class="form-control" type="date" name="paid_at" value="<?= htmlspecialchars($payment['paid_at'] ?? '') ?>">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=payments/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>