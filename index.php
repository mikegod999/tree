<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

use src\controllers\TreeController;
use src\models\blogic\TreeManager;
use src\models\repository\TreeNodeRepository;

require __DIR__ . '/vendor/autoload.php';
$configFile = __DIR__ . '/src/config/db.php';

if (!file_exists($configFile)) {
    die('Config file not exist');
}
$config = require $configFile;

/** db connection */
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

try {
    $pdo = new PDO($dsn, $config['user'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('DB connection failed: ' . $e->getMessage());
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$repository = new TreeNodeRepository($pdo);
$manager = new TreeManager($repository);
$controller = new TreeController($manager);

/** routing */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    header('Content-Type: application/json');
    switch ($uri) {
        case '/tree/create':
            echo json_encode($controller->create($_POST));
        break;
        case '/tree/delete':
            echo json_encode($controller->delete($_POST));
        break;
        case '/tree/edit':
            echo json_encode($controller->edit($_POST));
        break;
        default:
            http_response_code(404);
            echo '404 Not Found';
    }

    exit;
}

$controller->index();
