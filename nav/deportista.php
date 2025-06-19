<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/db.php';

$db = getDb();

$errors = [];
$openModal = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = $_POST['birthdate'] ?? null;

    if ($name === '') {
        $errors[] = 'El nombre es obligatorio';
    }

    if (!$errors) {
        $stmt = $db->prepare('INSERT INTO athletes (name, email, birthdate) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email ?: null, $birthdate ?: null]);
        header('Location: deportista.php');
        exit;
    } else {
        $openModal = true;
    }
}

$stmt = $db->query('SELECT id, name, email FROM athletes ORDER BY id DESC');
$athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);

include './../includes/header.php';
include './../includes/nav.php';
?>

<section class="content">
    <div class="left-content">
        <div class="activities">
            <h1>Deportistas</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($athletes as $athlete): ?>
                    <tr>
                        <td><?php echo $athlete['id']; ?></td>
                        <td><?php echo htmlspecialchars($athlete['name']); ?></td>
                        <td><?php echo htmlspecialchars($athlete['email']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="add-athlete-form">
            <button id="openModal" class="btn btn-primary mb-3">Añadir Deportista</button>
        </div>

        <div id="athleteModal" class="simple-modal <?php echo $openModal ? 'show' : ''; ?>">
            <div class="modal-content">
                <button type="button" class="btn-close" id="closeModal"></button>
                <h2>Añadir Deportista</h2>
                <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
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
    </div>
    <div class="right-content">
        <div class="user-info">
            <div class="icon-container">
                <i class="fa fa-bell nav-icon"></i>
                <i class="fa fa-message nav-icon"></i>
            </div>
            <h4>Maria Flores</h4>
            <img src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/40b7cce2-c289-4954-9be0-938479832a9c" alt="user" />
        </div>
    </div>
</section>

<script>
  (function() {
    const modal = document.getElementById('athleteModal');
    const openBtn = document.getElementById('openModal');
    const closeBtn = document.getElementById('closeModal');
    if(openBtn){
      openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.add('show');
      });
    }
    if(closeBtn){
      closeBtn.addEventListener('click', function() {
        modal.classList.remove('show');
      });
    }
  })();
</script>

<?php include './../includes/footer.php'; ?>
