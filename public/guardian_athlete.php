<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/GuardianAthlete.php';
require_once __DIR__ . '/../app/Controllers/GuardianAthleteController.php';

use App\Controllers\GuardianAthleteController;

$route = $_GET['r'] ?? 'guardian_athlete/list';

$controller = new GuardianAthleteController();

switch ($route) {
    case 'guardian_athlete/list':
        $controller->list();
        break;
    case 'guardian_athlete/form':
        $controller->form();
        break;
    case 'guardian_athlete/save':
        $controller->save();
        break;
    case 'guardian_athlete/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}