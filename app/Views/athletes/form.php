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
          <hr>
        <h4>Modalidades</h4>
        <div id="modalidadesContainer">
            <?php foreach ($relations as $i => $rel): ?>
                <?php $levels = $levelsList[$i] ?? []; ?>
                <?php $subs   = $subsList[$i] ?? []; ?>
                <div class="modalidad-group mb-3 d-flex align-items-end">
                    <div class="me-2 flex-grow-1">
                        <label>Modalidad:
                            <select name="modalidad_id[]" class="form-control modalidadSelect" required>
                                <option value="">--Selecciona--</option>
                                <?php foreach ($modalidades as $m): ?>
                                    <option value="<?= $m['id'] ?>" <?= $m['id']==$rel['modalidad_id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <div class="me-2 flex-grow-1">
                        <label>Nivel:
                            <select name="nivel_id[]" class="form-control nivelSelect" required>
                                <option value="">--Selecciona--</option>
                                <?php foreach ($levels as $lvl): ?>
                                    <option value="<?= $lvl['id'] ?>" <?= $lvl['id']==$rel['nivel_id'] ? 'selected' : '' ?>><?= htmlspecialchars($lvl['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <div class="me-2 flex-grow-1">
                        <label>Subnivel:
                            <select name="subnivel[]" class="form-control subnivelSelect">
                                <option value="">— sin subnivel —</option>
                                <?php foreach ($subs as $s): ?>
                                    <option value="<?= htmlspecialchars($s) ?>" <?= $s===$rel['subnivel'] ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <?php if ($i > 0): ?>
                        <button type="button" class="btn btn-danger btn-sm removeGroup">✕</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="addModalidadBtn" class="btn btn-sm btn-secondary mb-3">+ Añadir modalidad</button>

        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="?r=athletes/list">Cancelar</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('modalidadesContainer');
        const addBtn = document.getElementById('addModalidadBtn');

        function bindGroup(group) {
            const modSel = group.querySelector('.modalidadSelect');
            const lvlSel = group.querySelector('.nivelSelect');
            const subSel = group.querySelector('.subnivelSelect');
            const remBtn = group.querySelector('.removeGroup');

            modSel.addEventListener('change', () => {
                fetch('../api/get_levels.php?modalidad_id=' + modSel.value)
                    .then(r => r.json())
                    .then(levels => {
                        lvlSel.innerHTML = '<option value="">--Selecciona--</option>';
                        levels.forEach(l => {
                            const opt = document.createElement('option');
                            opt.value = l.id;
                            opt.textContent = l.nombre;
                            lvlSel.appendChild(opt);
                        });
                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                    });
            });

            lvlSel.addEventListener('change', () => {
                fetch('../api/get_sublevels.php?nivel_id=' + lvlSel.value)
                    .then(r => r.json())
                    .then(subs => {
                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                        subs.forEach(s => {
                            const opt = document.createElement('option');
                            opt.value = s.nombre;
                            opt.textContent = s.nombre;
                            subSel.appendChild(opt);
                        });
                    });
            });

            remBtn?.addEventListener('click', () => group.remove());
        }

        container.querySelectorAll('.modalidad-group').forEach(bindGroup);

        addBtn.addEventListener('click', () => {
            const template = container.querySelector('.modalidad-group');
            const clone = template.cloneNode(true);
            clone.querySelectorAll('select').forEach(sel => sel.value = '');
            clone.querySelector('.removeGroup')?.classList.remove('d-none');
            container.appendChild(clone);
            bindGroup(clone);
        });
    });
</script>
<?php include __DIR__ . '/../../../includes/footer.php'; ?>