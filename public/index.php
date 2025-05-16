<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Routes\Router;
use Dotenv\Dotenv;

header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtener la ruta solicitada (sin query string)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$body = file_get_contents('php://input');
$data = json_decode($body, true);

Router::handle($request, $method, $data);