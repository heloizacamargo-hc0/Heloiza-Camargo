<?php
declare(strict_types=1);

$baseDir = dirname(__DIR__);
require_once $baseDir . '/app/bootstrap.php';

// Garante o carregamento direto dos controladores caso o autoloader falhe
foreach (['AuthController', 'DashboardController', 'MovementController', 'ProductController', 'UserController'] as $ctrl) {
    $ctrlFile = $baseDir . '/app/Controllers/' . $ctrl . '.php';
    if (is_file($ctrlFile)) {
        require_once $ctrlFile;
    }
}

use App\Controllers\{AuthController, DashboardController, MovementController, ProductController, UserController};

$routes = [
    'GET' => [
        ''                => [DashboardController::class, 'index'],
        'dashboard'       => [DashboardController::class, 'index'],
        'login'           => [AuthController::class, 'showLogin'],
        'products'        => [ProductController::class, 'index'],
        'products.create' => [ProductController::class, 'create'],
        'products.edit'   => [ProductController::class, 'edit'],
        'movements'       => [MovementController::class, 'index'],
        'movements.create'=> [MovementController::class, 'create'],
        'users'           => [UserController::class, 'index'],
        'password'        => [UserController::class, 'passwordForm'],
    ],
    'POST' => [
        'login.post'      => [AuthController::class, 'login'],
        'logout'          => [AuthController::class, 'logout'],
        'products.store'  => [ProductController::class, 'store'],
        'products.update' => [ProductController::class, 'update'],
        'products.delete' => [ProductController::class, 'delete'],
        'movements.store' => [MovementController::class, 'store'],
        'users.store'     => [UserController::class, 'store'],
        'users.toggle'    => [UserController::class, 'toggle'],
        'password.update' => [UserController::class, 'passwordUpdate'],
    ]
];

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$route  = (string)($_GET['r'] ?? '');
$target = $routes[$method][$route] ?? null;

if (!$target) {
    http_response_code(404);
    exit('Rota não encontrada.');
}

[$controller, $action] = $target;

if (!class_exists($controller)) {
    $esperado = $baseDir . '/app/Controllers/MovementController.php';
    exit("Erro: A classe {$controller} não foi carregada. Arquivo existe? " . (is_file($esperado) ? 'SIM (' . filesize($esperado) . ' bytes)' : 'NÃO encontrado em ' . $esperado));
}

(new $controller())->$action();