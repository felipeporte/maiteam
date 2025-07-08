<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($guardian['id']) ? 'Editar' : 'Nuevo' ?> Apoderado</h1>
    <form method="post" action="?r=guardians/save">
        <?php if (isset($guardian['id'])): ?>
            <input type="hidden" name="id" value="<?= $guardian['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Nombre:
                <input class="form-control" type="text" name="name" value="<?= htmlspecialchars($guardian['name'] ?? '') ?>" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:
                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($guardian['email'] ?? '') ?>">
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono:
                <input class="form-control" type="text" name="phone" value="<?= htmlspecialchars($guardian['phone'] ?? '') ?>">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=guardians/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>