<?php

namespace App\Routes;

use App\Controllers\EmailController;

class Router
{
    public static function handle($request, $method, $data)
    {
        switch ($request) {
            case '/api/service/mailer/send':
                if ($method === 'POST') {
                    EmailController::sendEmail($data);
                } else {
                    http_response_code(405);
                    echo json_encode(['error' => 'Method not allowed']);
                    exit;
                }

                break;

            case '/':
                if ($method === 'GET') {
                    echo json_encode(['Ok' => 'Server Working...']);
                    exit;
                }

                break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Path not found.']);
                exit;
        }
    }
}
