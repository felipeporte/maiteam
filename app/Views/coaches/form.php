<?php include __DIR__ . '/../../../includes/header.php'; ?>
<?php include __DIR__ . '/../../../includes/nav.php'; ?>
<div class="container py-4">
    <h1 class="mb-3"><?= isset($coach['id']) ? 'Editar' : 'Nuevo' ?> Entrenador</h1>
    <form method="post" action="?r=coaches/save">
        <?php if (isset($coach['id'])): ?>
            <input type="hidden" name="id" value="<?= $coach['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Nombre:
                <input class="form-control" type="text" name="name" value="<?= htmlspecialchars($coach['name'] ?? '') ?>" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:
                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($coach['email'] ?? '') ?>">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=coaches/list">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>