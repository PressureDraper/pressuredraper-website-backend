<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Routes\Router;
use Dotenv\Dotenv;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];

// Preflight
if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtener la ruta solicitada (sin query string)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$body = file_get_contents('php://input');
$data = json_decode($body, true);

Router::handle($request, $method, $data);