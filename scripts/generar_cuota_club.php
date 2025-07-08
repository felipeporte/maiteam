<?php
require_once __DIR__ . '/../app/Database.php';

use App\Database;

$db = Database::getConnection();

$month = $argv[1] ?? date('Y-m');
if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
    fwrite(STDERR, "Uso: php generate_club_dues.php [YYYY-MM]\n");
    exit(1);
}

$dueDate = $month . '-01';

$guardians = $db->query('SELECT id FROM guardians')->fetchAll(PDO::FETCH_COLUMN);

$stmt = $db->prepare('INSERT INTO club_dues (guardian_id, amount, due_date) VALUES (?,?,?)');

foreach ($guardians as $guardianId) {
    $stmt->execute([
        $guardianId,
        3000,
        $dueDate
    ]);
}

echo "Cuotas generadas para $month\n";