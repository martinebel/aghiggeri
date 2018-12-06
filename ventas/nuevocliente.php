
  <?php
  include 'header.php';


  if(isset($_POST['action']))
  {
    switch($_POST['action'])
    {
      case 'misdatos':

      $stmt = $dbh->prepare( "INSERT INTO `clientes`(`idcliente`, `razonsocial`, `cuit`, `telefono`, `direccion`, `localidad`, `provincia`, `email`, `password`, `tipo`, `idsistema`, `iva`, `idvendedor`) VALUES 
        (NULL,'".$_POST['nombre']."',
        '".$_POST['cuit']."',
         '".$_POST['telefono']."',
           '".$_POST['direccion']."',
           '".$_POST['localidad']."',
           '".$_POST['provincia']."',
          '".$_POST['email']."',
           '123',
           1,
           NULL,
           2,
           ".$_SESSION['cid'].");");
      $stmt->execute();
      $idcliente=$dbh->lastInsertId();
      $uid=generateSession();
    $_SESSION['uid']=$uid;

    $stmt=$dbh->prepare("insert into temp_pedidos_header_vendedor (`idpedido`, `fecha`, `idcliente`, `clave`, `total`, `idvendedor`, `estado`)
     values (NULL,'".date('Y-m-d')."','".$idcliente."','".$uid."',0,'".$_SESSION['cid']."','')");
    $stmt->execute();
    $idpedido=$dbh->lastInsertId();

 $stmt=$dbh->prepare("select * from clientes where idcliente='".$idcliente."'");
   $stmt->execute();
   $result2 = $stmt->fetchAll(); 
    foreach($result2 as $row)
    {
     
    //$_SESSION['uid']=$row["clave"];
      $_SESSION['clienteid']=$row["idcliente"];
      $_SESSION['idpedido']=$idpedido;
      $_SESSION['tipousuario']=$row["tipo"];
    }
    echo '<script>window.location.href="home.php";</script>';exit();
      break;
      case 'npass':
      $stmt = $dbh->prepare("update clientes set password='".md5($_POST['npass'])."' where idcliente=".$_SESSION['cid']);
      $stmt->execute();
      echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Su contraseña fue modificada con exito!
</div>';
      break;
    }
  }
  ?>
    
    
    
    
  <div class="container">
   <div class="row">
      <div class="col-md-12" style="margin-top:40px;">

	 <form action="nuevocliente.php" method="post" style="padding:10px;">
                            <fieldset>
		
							<input type="hidden" name="action" value="misdatos">
							<div class="row">
							<div class="col-md-12">
                               <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre / Razon Social" required>
  </div>
  </div>
  <div class="col-md-6">
                                 <div class="form-group">
    <label for="cuit">DNI / CUIT</label>
    <input type="text" class="form-control" id="cuit" name="cuit"  placeholder="DNI / CUIT"  required>
  </div>
  </div>
  <div class="col-md-6">
                                 <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email"  placeholder="Email">
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="Telefono"  required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion"  required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="localidad">Localidad</label>
    <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad"  required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="provincia">Provincia</label>
    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" required>
  </div>
  </div>
                                
                              <div class="col-md-6 col-md-offset-3">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Guardar">
								</div>
                            </fieldset>
                        </form>
	</div>
       
                </div>
            </div>
    
    
  <?php
  include 'footer.php';
  ?>
