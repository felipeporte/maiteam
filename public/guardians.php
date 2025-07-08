<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/Guardian.php';
require_once __DIR__ . '/../app/Controllers/GuardianController.php';

use App\Controllers\GuardianController;

$route = $_GET['r'] ?? 'guardians/list';

$controller = new GuardianController();

switch ($route) {
    case 'guardians/list':
        $controller->list();
        break;
    case 'guardians/form':
        $controller->form();
        break;
    case 'guardians/save':
        $controller->save();
        break;
    case 'guardians/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}