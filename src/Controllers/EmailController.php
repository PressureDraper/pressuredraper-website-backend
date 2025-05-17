<?php

namespace App\Controllers;

use App\Utils\Validator;
use App\Services\Mailer;

class EmailController
{
    public static function sendEmail($data)
    {
        // Add your email sending logic here
        /* echo $data['name'], $data['email'], $data['topic'], $data['message']; */
        if (!isset($data['email'], $data['name'], $data['message'], $data['topic'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields.']);
            exit;
        }

        // Validar formato de email
        if (!Validator::isValidEmail($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Email. Please try again.']);
            exit;
        }

        $sent = Mailer::emailService($data);

        if ($sent) {
            http_response_code(200);
            echo json_encode(['message' => 'Email sent successfully. We will reach you in short.']);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Server error. Contact the administrator.']);
            exit;
        }
    }
}
