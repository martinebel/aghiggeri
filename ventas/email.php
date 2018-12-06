<?php
require 'PHPMailer/PHPMailerAutoload.php';

function sendMail($asunto,$mensaje){

$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();  
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);                                    // Set mailer to use SMTP
$mail->Host = 'mail.agustinghiggeri.com.ar';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'clientes@agustinghiggeri.com.ar';                 // SMTP username
$mail->Password = 'WeBapg25m';                           // SMTP password
$mail->SMTPSecure = false;                            // Enable TLS encryption, `ssl` also accepted

$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('clientes@agustinghiggeri.com.ar', 'Agustin Ghiggeri');
$mail->addAddress('clientes@agustinghiggeri.com.ar', 'Agustin Ghiggeri');     // Add a recipient              // Name is optional


/*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $asunto;
$mail->Body    = $mensaje;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//$mail->send();
if(!$mail->send()) {
	echo json_encode(array('message' => 'Message could not be sent.', 'msg' => $mail->ErrorInfo,'code'=>404));
} else {
    echo json_encode(array('message' => 'Message sent.', 'code'=>200));
}
}
?>