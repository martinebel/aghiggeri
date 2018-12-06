
  <?php
  if(!isset($_REQUEST["token"]))
  {
    header("Location: index.php");
die();
  }
  include 'header.php';
  require 'PHPMailer/PHPMailerAutoload.php';
  $status=false;

  if(isset($_POST["password"]))
  {
    
    $stmt = $dbh->prepare("select * from clientes where password='".$_POST["token"]."'");
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

$stmt = $dbh->prepare("update clientes set password='".$_POST["password"]."' where idcliente='".$codigo."'");

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
/*$mail->Body    = '<h3>Hola, '.$nombre.'</h3><hr><p>Se ha modificado su clave de acceso de manera correcta. Ya puede iniciar su sesion <a href="http://agustinghiggeri.com.ar/login.php" target="_blank">haciendo clic aqui</a></p><br><p>Agustin Ghiggeri - Distribuidor de Autopiezas</p><p>Atención al Cliente 0362 – 4433100 - 4451555</p>';*/
$html_template=file_get_contents('./templates/reset.html');
$html_template=str_replace('{{ client_name }}', $nombre, $html_template);
$mail->Body    = $html_template;
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

  if($status){
	echo '<div class="alert alert-success" role="alert">Su clave de acceso se modifico con exito. Ya puede iniciar su sesion <a href="login.php">haciendo clic aqui</a></div>';
}
else
{
  echo ' <form action="reset.php" method="post" id="form">
                            <fieldset>
                              <div class="form-group">
                                 <input class="form-control" placeholder="Nueva Clave" name="password" id="password" type="password" autofocus required>
                              </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Repita la Nueva Clave" name="newpassword" id="newpassword" type="password" autofocus required>
                                </div>
                               <p id="matchAlert" class="text-danger" style="display: none">La clave ingresada no coincide. Ambos campos deben ser iguales</p>
                                <input type="hidden" name="token" value="'.$_REQUEST["token"].'">
                                <a href="#" class="btn btn-lg btn-success btn-block" onclick="validate();">Guardar</a>
                                
                            </fieldset>
                        </form>';
}

?>
      
                       
                    </div>
                </div>
            </div>
        </div>
</div>  
    
    
    
    
    
  <?php
  include 'footer.php';
  ?>
<script>
function validate()
{
  if($("#password").val() != $("#newpassword").val())
  {
    $("#matchAlert").show();
  }
  else
    {$("#form").submit();}
}
</script>