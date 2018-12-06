  <?php
  include 'header.php';
  ?>
    <style>

body { 

  font-family: arial, sans-serif;
  line-height: 100%;
}

.steps{text-align:center;}

.steps  ul {
    margin: 0;
    padding: 0;
}
  .steps   li {
      font-size: 16px;
      position: relative;
      padding-right: 20px;
      display: inline-block;
      color: #999;
      line-height: 40px;
      padding-left: 60px; 
} 
      .steps li:last-child { padding-right: 0; }
      
      .normal:before {
        left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%;
        
      }
.is-active:before,.is-current:before {left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%; border-color: #69a53a; }
 .is-active  span:before { display: block; } 
      
      span:before {
          font-family: FontAwesome;
          font-style: normal;
          font-weight: normal;
          line-height: 1;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          
          color: #fff;
          padding: 0;
         left: 0px;
    bottom: 0px;
    display: none;
    font-size: 30px;
    content: "\f00c";
    text-align: center;
    position: absolute;
    background: #69a53a;
    width: 40px;
    height: 40px;
    border: 3px solid #69a53a;
          
          border-radius:100%;
        }
</style>
    <div class="container" style=" padding-top: 20px;">
	<div class="steps">
  <ul>
    <li class="is-active"><span><a href="cart.php">Confirmar Pedido</a></span></li>
    <li class="is-current"><span>Datos del Cliente</span></li>
    <li class="normal"><span>Finalizado</span></li>
  </ul>
</div>
<hr>
<div class="row" <?php if(!isset($_SESSION['cid'])){echo 'style="display:none"';}?>>
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
		}
		echo '<div class="col-md-6 col-md-offset-3 col-xs-12">
<div class="panel panel-default">
  <div class="panel-body">
  <form method="POST" action="checkout-step4.php">
  <p><strong>'.$nombre.'</strong></p>
  <p>'.$direccion.'</p>
  <p>'.$telefono.'</p>
  <p>'.$email.'</p>
  <hr>
  <p>Si lo desea, puede agregar observaciones a su pedido</p>
  <p><input type="text" class="form-control" name="observaciones" placeholder="Observaciones"></p>
  <button type="submit" class="btn btn-success">Continuar <i class="fa fa-angle-right"></i></button>
  </form>
  </div>
  </div>
  </div>';
		
							?>
</div>



<div class="row" <?php if(isset($_SESSION['cid'])){echo 'style="display:none"';}?>>
<?php
if(isset($_REQUEST['e']))
{
	echo '<div class="alert alert-danger" role="alert">El cliente no se encuentra o los datos son incorrectos.</div>';
}
?>
<form method="POST" action="checkout-step2.php" id="datoscliente">

<div class="col-md-6 col-xs-12">
<div class="panel panel-default">
  <div class="panel-body">
<div class="row">
<div class="col-md-12" style="text-align:center"><legend>Cliente nuevo</legend></div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="cliente">Nombre / Razon Social</label>
    <input type="text" class="form-control" id="cliente" name="cliente" required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="dni">Tipo Cliente</label>
   <select class="form-control" id="iva" name="iva" required>
	<option value="1">CONSUMIDOR FINAL</option>
	<option value="2">RESP INSCRIPTO</option>
	<option value="4">MONOTRIBUTO</option>
	<option value="5">EXENTO</option>
	</select>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="dni">DNI / CUIT</label>
    <input type="text" class="form-control" id="dni" name="dni"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono"  required>
  </div>
</div>
<div class="col-md-12 col-xs-12">
<div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" class="form-control" id="direccion" name="direccion"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="localidad">Localidad</label>
    <input type="text" class="form-control" id="localidad" name="localidad"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="provincia">Provincia</label>
    <input type="text" class="form-control" id="provincia" name="provincia"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="email">Ingrese una contraseña</label>
    <input type="password" class="form-control" id="pass" name="pass"  required>
  </div>
</div>

<div class="col-md-12" style="text-align:center">
<button  type="submit" class="btn btn-success">Enviar Pedido <i class="fa fa-angle-right"></i></button>
</div>
</div>
</div>
</div>
</div>
</form>

<form method="POST" action="checkout-step3.php" id="clienteexiste">

<div class="col-md-6 col-xs-12">
<div class="panel panel-default">
  <div class="panel-body">
<div class="row">
<div class="col-md-12" style="text-align:center"><legend>Cliente ya registrado</legend></div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email"  required>
  </div>
</div>
<div class="col-md-6 col-xs-12">
<div class="form-group">
    <label for="email">Contraseña</label>
    <input type="password" class="form-control" id="pass" name="pass"  required>
  </div>
</div>
<div class="col-md-12" style="text-align:center">
<button  type="submit" class="btn btn-success">Enviar Pedido <i class="fa fa-angle-right"></i></button>
</div>
</div></div></div></div>
</form>
</div>
	
							
							
							
					
					
					
				</div>
			
      <?php
  include 'footer.php';
  ?>
