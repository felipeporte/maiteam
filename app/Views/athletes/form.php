<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($athlete['id']) ? 'Editar' : 'Nuevo' ?> Deportista</h1>
    <form method="post" action="?r=athletes/save">
        <?php if (isset($athlete['id'])): ?>
            <input type="hidden" name="id" value="<?= $athlete['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Nombre:
                <input class="form-control" type="text" name="name" value="<?= htmlspecialchars($athlete['name'] ?? '') ?>" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Rut:
                <input class="form-control" type="text" name="rut" value="<?= htmlspecialchars($athlete['rut'] ?? '') ?>">
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:
                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($athlete['email'] ?? '') ?>">
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento:
                <input class="form-control" type="date" name="birthdate" value="<?= htmlspecialchars($athlete['birthdate'] ?? '') ?>">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=athletes/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>