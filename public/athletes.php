<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/Athlete.php';
require_once __DIR__ . '/../app/Controllers/AthleteController.php';

use App\Controllers\AthleteController;

$route = $_GET['r'] ?? 'athletes/list';

$controller = new AthleteController();

switch ($route) {
    case 'athletes/list':
        $controller->list();
        break;
    case 'athletes/form':
        $controller->form();
        break;
    case 'athletes/save':
        $controller->save();
        break;
    case 'athletes/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}