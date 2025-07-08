<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Database.php';

$db = \App\Database::getConnection();

$errors = [];
$openModal = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = trim($_POST['name'] ?? '');
    $rut       = trim($_POST['rut'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $birthdate = $_POST['birthdate'] ?? null;

    if ($name === '') {
        $errors[] = 'El nombre es obligatorio';
    }

    if (!$errors) {
        $stmt = $db->prepare('INSERT INTO athletes (name, email, birthdate, rut) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email ?: null, $birthdate ?: null, $rut ?: null]);
        header('Location: deportista.php');
        exit;
    } else {
        $openModal = true;
    }
}

$stmt = $db->query('SELECT id, name, rut, email, birthdate FROM athletes ORDER BY id DESC');
$athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);

include './../includes/header.php';
include './../includes/nav.php';
?>

<section class="content-full">
    <div class="left-content">
        <div class="activities">
            <div class="container">
                <div class="row title">

                    <div class="col-2">
                        <h1>Deportistas</h1>
                    </div>

                    <!--  <button id="openModal" class="btn btn-primary mb-3">Añadir Deportista</button> -->

                    <div class="col-10">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                            <button class="btn btn-primary me-md-2" type="button">Añadir Deportista</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Email</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($$athletes as $athlete): ?>
                            <tr id="athlete-<?php echo $athlete['id']; ?>">
                                <td class="athlete-id"><?php echo htmlspecialchars($athlete['id']); ?></td>
                                <td class="athlete-name"><?php echo htmlspecialchars($athlete['name']); ?></td>
                                <td class="athlete-rut"><?php echo htmlspecialchars($athlete['rut']); ?></td>
                                <td class="athlete-email"><?php echo htmlspecialchars($athlete['email']); ?></td>
                                <td class="athlete-birthdate"><?php echo htmlspecialchars(date('d-m-Y', strtotime($athlete['birthdate']))); ?></td>
                                <td class="text-nowrap">
                                    <div class="btn-group d-none d-sm-inline-flex" role="group">
                                        <button class="btn btn-sm btn-light show-details" title="Ver ficha" data-id="<?php echo $athlete['id']; ?>"><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-sm btn-light edit-athlete" title="Editar" data-id="<?php echo $athlete['id']; ?>"><i class="fa fa-pen"></i></button>

                                        <form action="../actions/delete_athlete.php" method="post" class="delete-athlete-form d-inline">
                                            <input type="hidden" name="id" value="<?php echo $athlete['id']; ?>">
                                            <button class="btn btn-sm btn-light" title="Eliminar">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- modal Ver ficha -->
        <div id="athleteDetailsModal" class="simple-modal modal " tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="athleteDetailsModal">Ficha Deportista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeDetailsModal"></button>
                    </div>
                    <div id="athleteDetailsContent"></div>
                </div>
            </div>
        </div>

        <!-- modal Añadir Deportista -->
        <div id="athleteModal" class="simple-modal <?php echo $openModal ? 'show' : ''; ?>">
            <div class="modal-content">
                <button type="button" class="btn-close" id="closeModal"></button>
                <h2>Añadir Deportista</h2>
                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Nombre:
                            <input class="form-control" type="text" name="name" required>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rut:
                            <input class="form-control" type="text" name="rut">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:
                            <input class="form-control" type="email" name="email">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Nacimiento:
                            <input class="form-control" type="date" name="birthdate">
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <!-- modal Editar Deportista -->
        <div id="editAthleteModal" class="simple-modal">
            <div class="modal-content">
                <button type="button" class="btn-close" id="closeEditModal"></button>
                <div id="editAthleteContent"></div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ——————————————————————————
        // 1) Modales “Añadir” y “Ver ficha”
        // ——————————————————————————
        const createModal = document.getElementById('athleteModal');
        const openCreateBtn = document.getElementById('openModal');
        const closeCreateBtn = document.getElementById('closeModal');

        const detailsModal = document.getElementById('athleteDetailsModal');
        const detailsContent = document.getElementById('athleteDetailsContent');
        const closeDetailsBtn = document.getElementById('closeDetailsModal');

        // Abrir modal “Añadir”
        openCreateBtn?.addEventListener('click', e => {
            e.preventDefault();
            createModal.classList.add('show');
        });
        closeCreateBtn?.addEventListener('click', () => {
            createModal.classList.remove('show');
        });

        // Abrir modal “Ver ficha”
        document.querySelectorAll('.show-details').forEach(btn => {
            btn.addEventListener('click', function() {
                fetch(`../actions/get_athlete.php?id=${this.dataset.id}`)
                    .then(r => r.text())
                    .then(html => {
                        detailsContent.innerHTML = html;
                        detailsModal.classList.add('show');
                    });
            });
        });
        closeDetailsBtn?.addEventListener('click', () => {
            detailsModal.classList.remove('show');
        });

        // ——————————————————————————
        // 2) Modal “Editar” con múltiples modalidades
        // ——————————————————————————
        const editModal = document.getElementById('editAthleteModal');
        const editContent = document.getElementById('editAthleteContent');
        const closeEditBtn = document.getElementById('closeEditModal');

        document.querySelectorAll('.edit-athlete').forEach(btn => {
            btn.addEventListener('click', function() {
                fetch(`../actions/get_update_athlete.php?id=${this.dataset.id}`)
                    .then(r => r.text())
                    .then(html => {
                        // 2.1 Injectar el formulario
                        editContent.innerHTML = html;
                        editModal.classList.add('show');

                        // 2.2 Referencias a contenedor y botón “+ Añadir modalidad”
                        const container = editContent.querySelector('#modalidadesContainer');
                        const addBtn = editContent.querySelector('#addModalidadBtn');

                        // 2.3 Función para enlazar selects y botón “✕” en un grupo
                        function bindGroup(group) {
                            const modSel = group.querySelector('.modalidadSelect');
                            const lvlSel = group.querySelector('.nivelSelect');
                            const subSel = group.querySelector('.subnivelSelect');
                            const remBtn = group.querySelector('.removeGroup');

                            // Cuando cambia modalidad → recargar niveles
                            modSel.addEventListener('change', () => {
                                fetch(`../api/get_levels.php?modalidad_id=${modSel.value}`)
                                    .then(r => r.json())
                                    .then(levels => {
                                        lvlSel.innerHTML = '<option value="">--Selecciona nivel--</option>';
                                        levels.forEach(l =>
                                            lvlSel.innerHTML += `<option value="${l.id}">${l.nombre}</option>`
                                        );
                                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                                    })
                                    .catch(console.error);
                            });

                            // Cuando cambia nivel → recargar subniveles
                            lvlSel.addEventListener('change', () => {
                                fetch(`../api/get_sublevels.php?nivel_id=${lvlSel.value}`)
                                    .then(r => r.json())
                                    .then(subs => {
                                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                                        subs.forEach(s =>
                                            subSel.innerHTML += `<option value="${s.nombre}">${s.nombre}</option>`
                                        );
                                    })
                                    .catch(console.error);
                            });

                            // Botón “✕” para eliminar grupo
                            remBtn?.addEventListener('click', () => group.remove());
                        }

                        // 2.4 Enlazar todos los grupos ya existentes
                        container.querySelectorAll('.modalidad-group').forEach(bindGroup);

                        // 2.5 Función para clonar un nuevo grupo
                        function cloneGroup() {
                            const template = container.querySelector('.modalidad-group');
                            const clone = template.cloneNode(true);
                            // Limpiar selects
                            clone.querySelectorAll('select').forEach(sel => sel.value = '');
                            // Mostrar el botón de eliminar en el clone
                            const rem = clone.querySelector('.removeGroup');
                            if (rem) rem.style.display = 'inline-block';
                            // Añadir al DOM y enlazar listeners
                            container.appendChild(clone);
                            bindGroup(clone);
                        }

                        // 2.6 Ligar el click de “+ Añadir modalidad”
                        addBtn.addEventListener('click', cloneGroup);

                        // 2.7 Ligar selects y envío AJAX del formulario
                        bindDependentSelects(editContent);
                        bindEditFormSubmission(editContent);
                    });
            });

        
        });

        // Cerrar modal “Editar”
        closeEditBtn?.addEventListener('click', () => {
            editModal.classList.remove('show');
        });

        // ——————————————————————————
        // 3) Helpers para binds dinámicos
        // ——————————————————————————

        // 3.1 Selects dependientes dentro de un contexto (modal edit)
        function bindDependentSelects(context) {
            const modSel = context.querySelector('#modalidadSelect');
            const lvlSel = context.querySelector('#nivelSelect');
            const subSel = context.querySelector('#subnivelSelect');
            if (!modSel || !lvlSel) return;

            modSel.addEventListener('change', e => {
                fetch(`/0mai/maiteam/api/get_levels.php?modalidad_id=${e.target.value}`)
                    .then(r => r.json())
                    .then(levels => {
                        lvlSel.innerHTML = '<option value="">Selecciona nivel</option>';
                        levels.forEach(l =>
                            lvlSel.innerHTML += `<option value="${l.id}">${l.nombre}</option>`
                        );
                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                    })
                    .catch(console.error);
            });

            lvlSel.addEventListener('change', e => {
                fetch(`/0mai/maiteam/api/get_sublevels.php?nivel_id=${e.target.value}`)
                    .then(r => r.json())
                    .then(subs => {
                        subSel.innerHTML = '<option value="">— sin subnivel —</option>';
                        subs.forEach(s =>
                            subSel.innerHTML += `<option value="${s.nombre}">${s.nombre}</option>`
                        );
                    })
                    .catch(console.error);
            });
        }

        // 3.2 Envío AJAX del formulario de edición
        function bindEditFormSubmission(context) {
            const form = context.querySelector('#editAthleteForm');
            if (!form) return;
            form.addEventListener('submit', e => {
                e.preventDefault();
                const fd = new FormData(form);
                fetch('/0mai/maiteam/actions/update_athlete.php', {
                        method: 'POST',
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
                        // Refrescar fila en tabla principal
                        const row = document.getElementById(`athlete-${data.id}`);
                        if (row) {
                            row.querySelector('.athlete-name').textContent = data.name;
                            row.querySelector('.athlete-rut').textContent = data.rut;
                            row.querySelector('.athlete-email').textContent = data.email;
                            row.querySelector('.athlete-birthdate').textContent = data.birthdate_formatted;
                        }
                        editModal.classList.remove('show');
                    })
                    .catch(() => alert('Error al guardar los cambios'));
            });
        }
        // 4) Eliminar deportista con AJAX
        document.querySelectorAll('.delete-athlete-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            // confirmación
            if (!confirm('¿Eliminar deportista?')) return;

            const fd = new FormData(form);
            fetch(form.action, {
            method: 'POST',
            body: fd
            })
            .then(res => res.json())
            .then(data => {
            if (data.success) {
                // quitar fila de la tabla
                const row = document.getElementById(`athlete-${data.id}`);
                row?.remove();
            } else {
                alert('No se pudo eliminar: ' + (data.error || 'Error desconocido'));
            }
            })
            .catch(() => alert('Error al conectar con el servidor'));
        });
        });
    });
</script>


<?php include './../includes/footer.php'; ?>