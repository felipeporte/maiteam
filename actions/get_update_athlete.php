<?php
// get_update_athlete.php
// Formulario de edición de deportista con múltiples modalidades y selects dependientes

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/db.php';
$db = getDb();

// 1) Cargar deportista
$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare('SELECT * FROM deportistas WHERE id = ?');
$stmt->execute([$id]);
$athlete = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$athlete) {
    echo "<p>No se encontró el deportista.</p>";
    exit;
}

// 2) Cargar relaciones actuales (pueden ser varias)
$stmt = $db->prepare('
    SELECT modalidad_id, nivel_id, subnivel
      FROM deportista_modalidad
     WHERE deportista_id = ?
     ORDER BY modalidad_id
');
$stmt->execute([$id]);
$rels = $stmt->fetchAll(PDO::FETCH_ASSOC);
// si no tiene ninguna relación, dejamos un vacío para mostrar 1 grupo
if (empty($rels)) {
    $rels = [['modalidad_id' => null, 'nivel_id' => null, 'subnivel' => null]];
}

// 3) Listar todas las modalidades
$mods = $db
    ->query('SELECT id,nombre FROM modalidades ORDER BY nombre')
    ->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Editar Deportista</h3>
<form class="row g-3" id="editAthleteForm" method="post" action="../actions/update_athlete.php" data-id="<?= $id ?>">
    <input type="hidden" name="id" value="<?= $id ?>">

    <!-- Campos básicos -->
    <div class="col-12"> 
        <label class="form-label">Nombre:</label>
            <input type="text" name="name" class="form-control"
                value="<?= htmlspecialchars($athlete['name']) ?>" required>

    </div>
    <div class="col-md-6">
        <label>RUT:</label>
        
            <input type="text" name="rut" class="form-control"
                value="<?= htmlspecialchars($athlete['rut']) ?>">

    </div>
    <div class="col-md-6">
        <label>Email:        </label>
            <input type="email" name="email" class="form-control"
                value="<?= htmlspecialchars($athlete['email']) ?>">

    </div>
    <div class="col-md-6">
        <label>Fecha de nacimiento:        </label>
            <input type="date" name="birthdate" class="form-control"
                value="<?= htmlspecialchars($athlete['birthdate']) ?>">

    </div>

    <hr>
    <h4>Modalidades</h4>
    <div id="modalidadesContainer">
        <?php foreach ($rels as $i => $rel):
            // precargar niveles según modalidad seleccionada:
            $levels = [];
            if ($rel['modalidad_id']) {
                $stmt2 = $db->prepare('SELECT id,nombre FROM niveles WHERE modalidad_id=? ORDER BY nombre');
                $stmt2->execute([$rel['modalidad_id']]);
                $levels = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
            // precargar subniveles según nivel seleccionado:
            $subs = [];
            if ($rel['nivel_id']) {
                $stmt3 = $db->prepare("
              SELECT DISTINCT subnivel 
                FROM condicionales_categoria 
               WHERE nivel_id=? 
                 AND subnivel IS NOT NULL
               ORDER BY subnivel
            ");
                $stmt3->execute([$rel['nivel_id']]);
                $subs = $stmt3->fetchAll(PDO::FETCH_COLUMN);
            }
        ?>
            <div class="modalidad-group mb-3 d-flex align-items-end">
                <!-- Modalidad -->
                <div class="me-2 flex-grow-1">
                    <label>Modalidad:
                        <select name="modalidad_id[]" class="form-control modalidadSelect" required>
                            <option value="">--Selecciona--</option>
                            <?php foreach ($mods as $m): ?>
                                <option value="<?= $m['id'] ?>"
                                    <?= $m['id'] == $rel['modalidad_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <!-- Nivel -->
                <div class="me-2 flex-grow-1">
                    <label>Nivel:
                        <select name="nivel_id[]" class="form-control nivelSelect" required>
                            <option value="">--Selecciona--</option>
                            <?php foreach ($levels as $lvl): ?>
                                <option value="<?= $lvl['id'] ?>"
                                    <?= $lvl['id'] == $rel['nivel_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($lvl['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <!-- Subnivel -->
                <div class="me-2 flex-grow-1">
                    <label>Subnivel:
                        <select name="subnivel[]" class="form-control subnivelSelect">
                            <option value="">— sin subnivel —</option>
                            <?php foreach ($subs as $s): ?>
                                <option value="<?= htmlspecialchars($s) ?>"
                                    <?= $s === $rel['subnivel'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <!-- Botón quitar para grupos adicionales -->
                <?php if ($i > 0): ?>
                    <button type="button" class="btn btn-danger btn-sm removeGroup">✕</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" id="addModalidadBtn" class="btn btn-sm btn-secondary mb-3">
        + Añadir modalidad
    </button>

    <button class="btn btn-primary" type="submit">Guardar cambios</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('modalidadesContainer');
        const addBtn = document.getElementById('addModalidadBtn');

        // Ligar eventos y lógica de cada grupo
        function bindGroup(group) {
            const modSel = group.querySelector('.modalidadSelect');
            const lvlSel = group.querySelector('.nivelSelect');
            const subSel = group.querySelector('.subnivelSelect');
            const remBtn = group.querySelector('.removeGroup');

            // onChange modalidad → recargar niveles
            modSel.addEventListener('change', () => {
                fetch(`../api/get_levels.php?modalidad_id=${modSel.value}`)
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
                    })
                    .catch(console.error);
            });

            // onChange nivel → recargar subniveles
            lvlSel.addEventListener('change', () => {
                fetch(`../api/get_sublevels.php?nivel_id=${lvlSel.value}`)
                    .then(r => r.json())
                    .then(subs => {
                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                        subs.forEach(s => {
                            const opt = document.createElement('option');
                            opt.value = s.nombre;
                            opt.textContent = s.nombre;
                            subSel.appendChild(opt);
                        });
                    })
                    .catch(console.error);
            });

            // Quitar grupo
            remBtn?.addEventListener('click', () => group.remove());
        }

        // Enlazar todos los grupos existentes
        container.querySelectorAll('.modalidad-group').forEach(bindGroup);

        // Añadir un nuevo grupo (clon del primero)
        addBtn.addEventListener('click', () => {
            const template = container.querySelector('.modalidad-group');
            const clone = template.cloneNode(true);
            // resetear valores
            clone.querySelectorAll('select').forEach(sel => sel.value = '');
            // mostrar botón quitar
            clone.querySelector('.removeGroup')?.classList.remove('d-none');
            container.appendChild(clone);
            bindGroup(clone);
        });
    });
</script>