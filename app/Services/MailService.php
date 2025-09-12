<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public function __construct(private ?PHPMailer $mailer = null) {
        if(!$this->mailer) {
            $m = new PHPMailer(true);
            $m->isSMTP();
            $m->Host = getenv('SMTP_HOST') ?: 'localhost';
            if ($port = getenv('SMTP_PORT')) $m->Port = (int)$port; else $m->Port = 25;
            if (getenv('SMTP_USER')) {
                $m->SMTPAuth = true;
                $m->Username = getenv('SMTP_USER');
                $m->Password = getenv('SMTP_PASS') ?: '';
            }
            $m->CharSet = 'UTF-8';
            $m->setFrom(getenv('MAIL_FROM') ?: 'no-reply@example.com', getenv('MAIL_FROM_NAME') ?: 'Sistema');
            $this->mailer = $m;
        }
    }

    public function send(string $to, string $subject, string $html): bool {
        try {
            $this->mailer->clearAllRecipients();
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $html;
            $this->mailer->AltBody = strip_tags($html);
            return $this->mailer->send();
        } catch (Exception $e) {
            // logar erro futuramente
            return false;
        }
    }
}
