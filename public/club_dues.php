<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/ClubDue.php';
require_once __DIR__ . '/../app/Controllers/ClubDueController.php';

use App\Controllers\ClubDueController;

$route = $_GET['r'] ?? 'club_dues/list';

$controller = new ClubDueController();

switch ($route) {
    case 'club_dues/list':
        $controller->list();
        break;
    case 'club_dues/form':
        $controller->form();
        break;
    case 'club_dues/save':
        $controller->save();
        break;
    case 'club_dues/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
    }