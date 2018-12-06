<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Agustin Ghiggeri Distribuidor de Autopiezas - Av. 25 de Mayo 1164, Rcia Chaco - Llámanos ahora: 0362 - 4433100 - Whatsapp: 0362-155240760 -  Email: ventas@agustinghiggeri.com.ar">
    <meta name="author" content="Agustin Ghiggeri">
  <meta property="og:type" content="website" />
<meta property="og:image" content="http://www.agustinghiggeri.com/logo.png" />
<meta property="og:title" content="Agustin Ghiggeri" />
<meta property="og:description" content="Agustin Ghiggeri Distribuidor de Autopiezas - Av. 25 de Mayo 1164, Rcia Chaco - Llámanos ahora: 0362 - 4433100 - Whatsapp: 0362-155240760 -  Email: ventas@agustinghiggeri.com.ar" />
<meta property="og:site_name" content="Agustin Ghiggeri" />
  <link rel="shortcut icon" type="image/png" href="./favicon.png"/>

    <title>Agustin Ghiggeri</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css?version=0311" rel="stylesheet">

    <!-- Custom CSS -->

   <link href="../css/topBar.css?version=0311" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/sidemenu.css">
    <link href="../css/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
  <div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4" style="margin-top:40px;">
                <div class="login-panel panel panel-default">
                   
                    <div class="panel-body">
							<?php
if(isset($_REQUEST['e']))
{
	echo '<div class="alert alert-danger" role="alert">El usuario no se encuentra o los datos son incorrectos.</div>';
}
?>
      
                        <form action="validation.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="cuit" id="cuit" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" type="password" value="" required>
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Iniciar Sesion">
                                <br>
                                 
                                    
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>  
    
    
    
    
    
 <!-- jQuery -->
    <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
