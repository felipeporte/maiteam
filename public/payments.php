<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Models/Payment.php';
require_once __DIR__ . '/../app/Controllers/PaymentController.php';

use App\Controllers\PaymentController;

$route = $_GET['r'] ?? 'payments/list';

$controller = new PaymentController();

switch ($route) {
    case 'payments/list':
        $controller->list();
        break;
    case 'payments/form':
        $controller->form();
        break;
    case 'payments/save':
        $controller->save();
        break;
    case 'payments/delete':
        $controller->delete();
        break;
    default:
        http_response_code(404);
        echo 'Ruta no encontrada';
}