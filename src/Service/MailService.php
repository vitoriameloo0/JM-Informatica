<?php

namespace src\Service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/src/SMTP.php';

class MailService
{
    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/mail.php';
    }
    // Funcao que ira enviar email apos finalizar o cadastro
    public function sendMail(string $email, string $name, string $description): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Configuração SMTP
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['username'];
            $mail->Password = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'];
            $mail->Port = $this->config['port'];

            // Remetente
            $mail->setFrom(
                $this->config['from_email'],
                $this->config['from_name']
            );

            // Destinatário
            $mail->addAddress($email, $name);

            // Conteúdo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $mail->Subject = 'Serviço finalizado';

            $mail->Body = "
                <h2>Serviço finalizado</h2>

                <p>Olá, <strong>{$name}</strong>!</p>

                <p>Seu serviço foi finalizado com sucesso.</p>
            ";

            $mail->AltBody =
                "Olá, {$name}!\n\n" .
                "Seu serviço foi finalizado com sucesso.\n\n" .
                "Serviço: {$description}\n";

            return $mail->send();

        } catch (Exception $e) {
            error_log('Erro ao enviar e-mail: ' . $mail->ErrorInfo);
            return false;
        }
    }

}