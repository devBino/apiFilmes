<?php
namespace App\Http\Repositories\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email{

    public static function sendEmail($data){
        
        $mail = new PHPMailer(true);

        try {
            
            //Configurações
            $mail->SMTPDebug = env('SMTP_DEBUG');
            $mail->isSMTP();             
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port       = env('MAIL_PORT');

            //Envio
            $mail->setFrom( env('MAIL_FROM_ADDRESS') , env('MAIL_FROM_NAME') );
            $mail->addAddress($data['endereco'], $data['nome']);
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') );
            
            //anexos
            //$mail->addAttachment('/var/tmp/file.tar.gz');
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Conteudo Html
            $mail->isHTML(true);
            $mail->Subject = $data['assunto'];
            $mail->Body    = $data['html'];

            $mail->send();

        } catch (Exception $e) {}

    }

}