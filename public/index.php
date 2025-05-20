<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Routes\Router;
use Dotenv\Dotenv;

class App
{
    private string $method;
    private string $request;
    private array|null $data;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setHeaders();
        $this->handlePreflight();
        $this->loadEnv();
        $this->parseRequest();
    }

    private function setHeaders(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    private function handlePreflight(): void
    {
        if ($this->method === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    private function loadEnv(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    private function parseRequest(): void
    {
        $this->request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $body = file_get_contents('php://input');
        $this->data = json_decode($body, true) ?? [];
    }

    public function run(): void
    {
        Router::handle($this->request, $this->method, $this->data);
    }
}

// Execute
$app = new App();
$app->run();