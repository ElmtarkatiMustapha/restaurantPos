<?php

namespace TOOL\Network;

use APP\Settings;
use PHPMailer\PHPMailer\PHPMailer;
use TOOL\Security\Auth;

class Mailer
{

    /**
     * File method
     * 
     * @param string $attch
     */
    static function file(string $attch)
    {

        $settings = Settings::get();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = config('SMTP_HOST', 'smtp.gmail.com');
        $mail->Port = config('SMTP_PORT', '587');
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = config('SMTP_USER', 'tacpro01@gmail.com');
        $mail->Password = config('SMTP_PASS', 'ieiq uhte skye oavr');
        $mail->SetFrom(config('SMTP_USER', 'tacpro01@gmail.com'), $settings->company->name ?? 'Nour');

        foreach (explode("\n", $settings->report->emails) as $email) {

            $mail->addAddress($email);
        }

        $mail->IsHTML(true);
        $mail->Subject = 'Rapport: ' . Auth::loggedIn()->username;
        $mail->Body    = 'Rapport';
        $mail->addAttachment($attch);
        $mail->AltBody = 'Rapport';

        $mail->send();
    }
}
