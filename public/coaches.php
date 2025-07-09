<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/Coach.php';
require_once __DIR__ . '/../app/Controllers/CoachController.php';

use App\Controllers\CoachController;

$route = $_GET['r'] ?? 'coaches/list';

$controller = new CoachController();

switch ($route) {
    case 'coaches/list':
        $controller->list();
        break;
    case 'coaches/form':
        $controller->form();
        break;
    case 'coaches/save':
        $controller->save();
        break;
    case 'coaches/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}