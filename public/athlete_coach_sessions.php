<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/AthleteCoachSession.php';
require_once __DIR__ . '/../app/Controllers/AthleteCoachSessionController.php';

use App\Controllers\AthleteCoachSessionController;

$route = $_GET['r'] ?? 'athlete_coach_sessions/list';

$controller = new AthleteCoachSessionController();

switch ($route) {
    case 'athlete_coach_sessions/list':
        $controller->list();
        break;
    case 'athlete_coach_sessions/form':
        $controller->form();
        break;
    case 'athlete_coach_sessions/save':
        $controller->save();
        break;
    case 'athlete_coach_sessions/delete':
        $controller->delete();
        break;
    case 'athlete_coach_sessions/report':
        $controller->report();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}