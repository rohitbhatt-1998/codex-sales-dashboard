<?php
require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../app/Core/Session.php';
require_once __DIR__ . '/../app/Core/Router.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $path = __DIR__ . '/../app/' . str_replace('App\\', '', $class) . '.php';
    $path = str_replace('\\', '/', $path);
    if (file_exists($path)) {
        require_once $path;
    }
});

use App\Core\Router;
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\CustomerController;
use App\Controllers\CallController;
use App\Controllers\KnowledgeController;
use App\Controllers\SettingController;
use App\Models\User;

Session::start();

if (!User::exists()) {
    User::create([
        'name' => 'Administrator',
        'email' => 'admin@aisalesagent.local',
        'password' => 'password123',
        'role' => 'admin',
    ]);
}

$router = new Router();

$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/customers', [CustomerController::class, 'index']);
$router->post('/customers/store', [CustomerController::class, 'store']);
$router->post('/customers/update', [CustomerController::class, 'update']);
$router->post('/customers/delete', [CustomerController::class, 'delete']);
$router->post('/customers/upload-csv', [CustomerController::class, 'uploadCsv']);

$router->get('/calls', [CallController::class, 'index']);
$router->post('/calls/call-now', [CallController::class, 'callNow']);

$router->get('/knowledge-base', [KnowledgeController::class, 'index']);
$router->post('/knowledge-base/upload', [KnowledgeController::class, 'upload']);

$router->get('/settings', [SettingController::class, 'index']);
$router->post('/settings/save', [SettingController::class, 'save']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
