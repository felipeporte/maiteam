<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($due['id']) ? 'Editar' : 'Registrar' ?> Cuota</h1>
    <form method="post" action="?r=club_dues/save">
        <?php if (isset($due['id'])): ?>
            <input type="hidden" name="id" value="<?= $due['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Apoderado:
                <select name="guardian_id" class="form-control" required>
                    <option value="">--Selecciona--</option>
                    <?php foreach ($guardians as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= $g['id']==($due['guardian_id']??'') ? 'selected' : '' ?>><?= htmlspecialchars($g['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Monto:
                <input class="form-control" type="number" step="0.01" name="amount" value="<?= htmlspecialchars($due['amount'] ?? '') ?>" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Vencimiento:
                <input class="form-control" type="date" name="due_date" value="<?= htmlspecialchars($due['due_date'] ?? '') ?>">
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Pago:
                <input class="form-control" type="date" name="paid_at" value="<?= htmlspecialchars($due['paid_at'] ?? '') ?>">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=club_dues/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>