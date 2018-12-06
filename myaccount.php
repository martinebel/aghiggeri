
  <?php
  include 'header.php';
  if(isset($_POST['action']))
  {
	  switch($_POST['action'])
	  {
		  case 'misdatos':

		  $stmt = $dbh->prepare( "update clientes set razonsocial='".$_POST['nombre']."', cuit='".$_POST['cuit']."', email='".$_POST['email']."', telefono='".$_POST['telefono']."', direccion='".$_POST['direccion']."',localidad='".$_POST['localidad']."',provincia='".$_POST['provincia']."' where idcliente=".$_SESSION['cid']);
			$stmt->execute();
			$_SESSION['cname']=$_POST['nombre'];
			$_SESSION['cemail']=$_POST['email'];
			echo '<script>window.location.href="myaccount.php";</script>';
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
                <div class="login-panel panel panel-default">
                   
                   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Mis Datos</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Mis pedidos</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Cambiar Contraseña</a></li>
	<li role="presentation"><a href="#estadocuenta" aria-controls="estadocuenta" role="tab" data-toggle="tab">Estado Cta. Cte.</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
	 <form action="myaccount.php" method="post" style="padding:10px;">
                            <fieldset>
							<?php
							$stmt = $dbh->prepare( "SELECT * from clientes where idcliente=".$_SESSION['cid']."");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			
foreach($result as $row)
		{
			$nombre=$row['razonsocial'];
			$cuit=$row['cuit'];
			$email=$row['email'];
			$direccion=$row['direccion'];
			$telefono=$row['telefono'];
			$localidad=$row['localidad'];
			$provincia=$row['provincia'];
      $idsistema=$row["idsistema"];
		}
							?>
							<input type="hidden" name="action" value="misdatos">
							<div class="row">
							<div class="col-md-12">
                               <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre / Razon Social" value="<?php echo $nombre;?>" required>
  </div>
  </div>
  <div class="col-md-6">
                                 <div class="form-group">
    <label for="cuit">DNI / CUIT</label>
    <input type="text" class="form-control" id="cuit" name="cuit"  placeholder="DNI / CUIT" value="<?php echo $cuit;?>" required>
  </div>
  </div>
  <div class="col-md-6">
                                 <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email"  placeholder="Email" value="<?php echo $email;?>">
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="Telefono" value="<?php echo $telefono;?>" required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" value="<?php echo $direccion;?>" required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="localidad">Localidad</label>
    <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" value="<?php echo $localidad;?>" required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="provincia">Provincia</label>
    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" value="<?php echo $provincia;?>" required>
  </div>
  </div>
                                
                              <div class="col-md-6 col-md-offset-3">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Guardar">
								</div>
                            </fieldset>
                        </form>
	</div>
    <div role="tabpanel" class="tab-pane" id="profile" style="padding:10px">
	<table class="table table-striped">
	<thead>
	<tr><th>ID</th><th>Fecha</th><th>Importe</th><th>Estado</th><th></th>
	</thead>
	<tbody>
	<?php
							$stmt = $dbh->prepare( "SELECT * from pedidos where cliente=".$_SESSION['cid']."  order by id desc limit 20");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			
foreach($result as $row)
		{
			echo '<tr><td>'.$row['id'].'</td><td>'.$row['fecha'].'</td><td>$'.$funciones->getTotalPedido($row['id']).'</td><td>'.$row['estado'].'</td><td><a class="btn btn-default" href="impresion.php?id='.$row['id'].'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a></td></tr>';
		}
		?>
		</tbody>
		</table>
	</div>
    <div role="tabpanel" class="tab-pane" id="messages" >
	 <form action="myaccount.php" method="post" style="padding:10px;">
                            <fieldset>
							<input type="hidden" name="action" value="npass">
							<div class="row">
							<div class="col-md-6 col-md-offset-3">
                               <div class="form-group">
    <label for="npass">Ingrese su nueva contraseña</label>
    <input type="password" class="form-control" id="npass" name="npass" placeholder="Nueva Contraseña">
  </div>
  </div>
   <div class="col-md-6 col-md-offset-3">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Cambiar">
								</div>
  </div>
  </fieldset>
  </form>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="estadocuenta" style="padding:10px">
	 <!--<table class="table table-striped">
	<thead>
	<tr><th>Nro</th><th>Comprobante</th><th>Fecha</th><th>Debe</th><th>Haber</th><th>Saldo</th>
	</thead>
	<tbody>
	<?php
	$idsistema="";
	$stmt = $dbh->prepare( "SELECT idsistema from clientes where idcliente=".$_SESSION['cid']);
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			
foreach($result as $row)
		{
			$idsistema=$row["idsistema"];
		}
		
		if(trim($idsistema)!=""){
	$stmt = $dbh->prepare( "SELECT * from ctacte where idcliente=".$idsistema."  order by fecha desc");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			$saldo=0;
foreach($result as $row)
		{
			echo '<tr><td>'.$row['numero'].'</td><td>'.$row['comprobante'].'</td><td>'.$row['fecha'].'</td><td>$'.$row['debe'].'</td><td>$'.$row['haber'].'</td><td>$'.$row['saldo'].'</td></tr>';
			
		}
		}
		?>
		</tbody>
		</table>-->

		<?php
		
foreach (glob("ctacte/".$idsistema." *.[pP][dD][fF]" ) as $filename) {
      echo '<a href="'.$filename.'" download="'.$filename.'" target="_blank">Descargar Estado de Cuenta</a>
      <object data="'.$filename.'" type="application/pdf" style="width:100%; height:500px">
        alt : <a href="'.$filename.'">'.$filename.'</a>
    </object>';
}
		?>
	</div>
  </div>

      
                       
                  
                </div>
            </div>
        </div>
</div>  
    
    
    
    
    
  <?php
  include 'footer.php';
  ?>
