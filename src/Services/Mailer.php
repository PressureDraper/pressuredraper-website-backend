<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    public static function emailService($data): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_USER'], $data['name']);
            $mail->addAddress($_ENV['SMTP_USER'], 'Receiver');

            $mail->isHTML(true);
            $mail->Subject = "WEBSITE MESSAGE";

            $message =
                "Topic: " . $data['topic'] . "\n" .
                "Name: " . strtoupper($data['name']) . "\n" .
                "Email: " . $data['email'] . "\n" .
                "Message: " . $data['message'];

            $mail->Body    = nl2br(htmlspecialchars($message));
            $mail->AltBody = strip_tags($message);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
