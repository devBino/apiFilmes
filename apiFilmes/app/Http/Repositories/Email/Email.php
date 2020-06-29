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

    public static function emailAdminPrimeiroAcesso($params){
        
        $msg = "Olá ".$params['nomeUsuario'].", você se cadastrou em nossa Api. Seu token é: ".sha1($params['nomeUsuario'].$params['email']);
        
        $link = env('APP_URL').":".env('API_PORT')."/usuarioAutorizacao/".$params['nomeUsuario']."/".$params['senhaUsuario']."/".sha1($params['nomeUsuario'].$params['email']);
        
        $data['endereco']   = $params['email'];
        $data['nome']       = $params['nomeUsuario'];
        $data['assunto']    = "Confirme seu Cadastro na apiFilmes";
        $data['html']       = view('email.email')->with( ['data'=>['message'=>$msg,'link'=>$link] ] )->render();

        self::sendEmail($data);
    }

}