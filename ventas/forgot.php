
  <?php
  include 'header.php';
  require 'PHPMailer/PHPMailerAutoload.php';
  $status=false;

  if(isset($_POST["cuit"]))
  {
    //comprobar que el cuit exista. 
    //si no existe, $status=false
    //si existe mandar mail, $status=true
    $stmt = $dbh->prepare("select * from clientes where cuit='".$_POST["cuit"]."'");
        $stmt->execute();
    $result = $stmt->fetchAll(); 
    $totalitems=$stmt->rowCount();
    if($totalitems>0)
    {
      foreach($result as $row)
      {
        $codigo=$row["idcliente"];
        $email=$row['email'];
        $nombre=ucwords($row['razonsocial']);
      }
      $token=md5(date('Y-m-d h:i:s'));
$stmt = $dbh->prepare("update clientes set password='".$token."' where cuit='".$_POST["cuit"]."'");
        $stmt->execute();      
      //enviar mail
      $mail = new PHPMailer;
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
$mail->addAddress($email, $nombre);     // Add a recipient              // Name is optional

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = "Agustin Ghiggeri - Clave de Acceso";
$mail->Body    = '<h3>Hola, '.$nombre.'</h3><hr><p>Hemos recibido una solicitud para recuperar su clave de acceso. Por favor, haga clic en el siguiente link para continuar con este proceso:</p><br><a href="http://agustinghiggeri.com.ar/reset.php?token='.$token.'" target="_blank">http://agustinghiggeri.com.ar/reset.php?token='.$token.'</a><br><br><p>Si usted no ha solicitado la recuperacion de su clave de acceso, por favor desestime este correo electronico</p><br><p>Agustin Ghiggeri - Distribuidor de Autopiezas</p><p>Atención al Cliente 0362 – 4433100 - 4451555</p>';
if(!$mail->send()) {
        echo json_encode(array('message' => 'Message could not be sent. '.$mail->ErrorInfo,'code'=>400));
} else {
$status=true;
}
    }
  }
  ?>
    
    
    
    
  <div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4" style="margin-top:40px;">
                <div class="login-panel panel panel-default">
                   
                    <div class="panel-body">
							<?php
if(isset($_POST["cuit"]))
{
  if($status){
	echo '<div class="alert alert-success" role="alert">Hemos enviado un mensaje a su direccion de mail. Por favor, reviselo para continuar con la operacion. Recuerde verificar en su carpeta de Spam o Correo No Deseado.</div>';
}
else
{
  echo '<div class="alert alert-danger" role="alert">No se ha podido enviar el mensaje o el numero de CUIT no corresponde con ningun cliente.</div>';
}
}
?>
      
                        <form action="forgot.php" method="post">
                            <fieldset>
                              <div class="form-group">
                                <p>Ingrese su CUIT y le enviaremos un mail con instrucciones para recuperar su acceso.</p>
                              </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="CUIT" name="cuit" id="cuit" type="text" autofocus required>
                                </div>
                               
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Enviar Mail">
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>  
    
    
    
    
    
  <?php
  include 'footer.php';
  ?>
<script>
  $(document).on("input", "#cuit", function() {
    this.value = this.value.replace(/\D/g,'');
});
</script>