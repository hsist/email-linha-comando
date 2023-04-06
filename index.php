<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$json = json_decode($argv[1], true);
$result = array("success" => true,"mensage" => "Mensagem enviada");

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->CharSet    = 'UTF-8';
    // -----------------------------------------------
    // Configuração para envio
    $mail->Host       = $json['host'];                          // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $json['user'];                          // SMTP username
    $mail->Password   = $json['password'];                      // SMTP password
    if ($json['secure'] == "SMTPS"){
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
    }
    $mail->Port       = $json['port'];                          // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    // -----------------------------------------------
    // Remetente
    $mail->setFrom($json['from'],$json['name']);                // Quem envia
    // -----------------------------------------------
    // Destinatários
    foreach($json['addres'] as $email) {
        $mail->addAddress($email['email']);                     // Quem recebe
    }
    // -----------------------------------------------
    // Anexos
    if(isset($json['attachment'])){
        foreach($json['attachment'] as $file) {
            $mail->addAttachment($file['file']);
        }
    }
    // -----------------------------------------------
    // Conteúdo
    if ($json['html'] == true){
        $mail->isHTML(true);                                    // Set email format to HTML
    } else {
        $mail->isHTML(false);
    }                             
    $mail->Subject = $json['content']['subject'];               // Assunto
    $mail->Body    = $json['content']['body'];                  // Corpo do e-mail
    $mail->AltBody = $json['content']['altbody'];               // Texto limpo, sem html (evita que a msg caia em spam)
    // -----------------------------------------------
    // Envio
    $mail->send();
    echo json_encode($result);

} catch (Exception $e) {
    $result['success'] = false;
    $result['mensage'] = "Mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
    echo json_encode($result);

}
