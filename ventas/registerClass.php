<?php
 //header('Content-Type: application/json');
include 'db.php';
require 'PHPMailer/PHPMailerAutoload.php';

$nombre=$_POST['nombre'];
$cuit=$_POST['cuit'];
$iva=$_POST['iva'];
$telefono=$_POST['telefono'];
$direccion=$_POST['direccion'];
$localidad=$_POST['localidad'];
$provincia=$_POST['provincia'];
$email=$_POST['email'];
$password=$_POST['pass'];

//revisar que este cuit no exista en la base de datos.
$stmt = $dbh->prepare("select * from clientes where cuit='".$cuit."'");
 $stmt->execute();
 $result = $stmt->fetchAll(); 
$contador=$stmt->rowCount();
if($contador==0)
{
	 $stmt = $dbh->prepare("insert into clientes values(NULL,'".$nombre."','".$cuit."','".$telefono."','".$direccion."','".$localidad."','".$provincia."','".$email."','".$password."',0,NULL,'".$iva."')");
	   $stmt->execute();
	   header('HTTP/1.1 201 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        
        $msg="<p><strong>Nuevo Registro de Cliente en agustinghiggeri.com.ar</strong></p>
        <hr>
        <p><strong>Codigo generado: </strong>".$dbh->lastInsertId()."</p>
        <p><strong>Nombre: </strong>".$nombre."</p>
        <p><strong>CUIT: </strong>".$cuit."</p>
        <p><strong>Telefono: </strong>".$telefono."</p>
        <p><strong>Direccion: </strong>".$direccion.", ".$localidad.", ".$provincia."</p>
        <p><strong>Email: </strong>".$email."</p>";

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

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

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = "Nuevo Cliente";
$mail->Body    = $msg;
if(!$mail->send()) {
        echo json_encode(array('message' => 'Message could not be sent. '.$mail->ErrorInfo,'code'=>400));
} else {
    echo json_encode(array('message' => 'Message sent.', 'code'=>201));
}
}
else
{
 header('HTTP/1.1 400 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'USUARIO YA EXISTE', 'code' => 400)));	
}
?>