  <?php
  include 'header.php';
  require_once('email.php');
  if(!isset($_POST['cliente'])){echo '<script>window.location.href="index.php";</script>';exit();}

  //guardar pedido
  $cliente=$_POST['cliente'];
  $dni=$_POST['dni'];
  $telefono=$_POST['telefono'];
  $direccion=$_POST['direccion'];
  $localidad=$_POST['localidad'];
  $provincia=$_POST['provincia'];
  $email=$_POST['email'];
   $iva=$_POST['iva'];
  $pass=$_POST['pass'];

  $stmt = $dbh->prepare("select * from clientes where cuit='".$dni."'");
   $stmt->execute();
   $result = $stmt->fetchAll();
  $contador=$stmt->rowCount();
  if($contador!=0)
  {
echo '<script>window.location.href="checkout-step1.php?e=2";</script>';exit();
  }

   $stmt=$dbh->prepare("insert into clientes (idcliente,razonsocial,cuit,telefono,direccion,localidad,provincia,email,password,tipo,idsistema,iva) values (NULL,'".$cliente."','".$dni."','".$telefono."','".$direccion."','".$localidad."','".$provincia."','".$email."','".$pass."',1,NULL,'".$iva."');");
	 $stmt->execute();
	 $idcliente=$dbh->lastInsertId();
   $msg="<p><strong>Nuevo Registro de Cliente en agustinghiggeri.com.ar</strong></p>
        <hr>
        <p><strong>Codigo generado: </strong>".$idcliente."</p>
        <p><strong>Nombre: </strong>".$cliente."</p>
        <p><strong>CUIT: </strong>".$dni."</p>
        <p><strong>Telefono: </strong>".$telefono."</p>
        <p><strong>Direccion: </strong>".$direccion.", ".$localidad.", ".$provincia."</p>
        <p><strong>Email: </strong>".$email."</p>";

        sendMail("Nuevo Cliente",$msg);


  $stmt=$dbh->prepare("insert into pedidos (id,cliente,fecha,estado,observaciones) values (NULL,'".$idcliente."','".date('Y-m-d')."','RECIBIDO','');");
	 $stmt->execute();
	 $ultimo=$dbh->lastInsertId();

 $stmt = $dbh->prepare("select productos.*,temp_pedidos.itemno,temp_pedidos.cant from temp_pedidos_header
    inner join temp_pedidos on temp_pedidos.id=temp_pedidos_header.idpedido
    inner join productos on productos.id=temp_pedidos.idproducto where temp_pedidos_header.clave='".$_SESSION['uid']."'");
        $stmt->execute();
		$result = $stmt->fetchAll();
		$total=0;
		foreach($result as $row)
		{
			$stmt=$dbh->prepare("insert into detallepedidos(idpedido,idproducto,cant,precio) values (".$ultimo.",".$row['id'].",".$row['cant'].",'".$funciones->getPrecioCant($row['id'],$_SESSION['tipousuario'],$row['cant'])."');");
			$stmt->execute();
		}

		//borrar temporal y finalizar sesion
   $stmt=$dbh->prepare("select * from temp_pedidos_header where clave='".$_SESSION['uid']."'");
   $stmt->execute();
   $result2 = $stmt->fetchAll();
    foreach($result2 as $row2)
    {
      $idpedido=$row2["idpedido"];
    }

  $stmt = $dbh->prepare("delete from temp_pedidos where id='".$idpedido."'");
        $stmt->execute();
        $stmt = $dbh->prepare("delete from temp_pedidos_header where idpedido='".$idpedido."'");
        $stmt->execute();
		$_SESSION = array();
 //Destruir Sesión
 session_destroy();
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
    <li class="is-active"><span>Confirmar Pedido</span></li>
    <li class="is-active"><span>Datos del Cliente</span></li>
    <li class="is-active"><span>Finalizado</span></li>
  </ul>
</div>
<hr>
<div class="row">
<div class="col-md-6 col-md-offset-3 col-xs-12" style="text-align:center">
<div class="alert alert-success" role="alert">
<h4>Finalizado!</h4>
<p>Su pedido ha sido enviado a nuestra sucursal. En breve, uno de nuestros vendedores se pondrá en contacto con usted.</p>
<p>Puede imprimir una copia de su pedido <a href="impresion.php?id=<?php echo $ultimo;?>" target="_blank">haciendo click aqui</a></p>
</div>
<a href="index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Volver al Inicio</a>
</div>


</div>







				</div>

      <?php
  include 'footer.php';
  ?>
