<?php 
require '../db.php';
if(isset($_POST['action']))
{
	
	
	 $codigo= $_POST['id'];
	 $idsistema= $_POST['idsistema'];
	 $razonsocial= $_POST['razonsocial'];
	 $cuit= $_POST['cuit'];
	 $telefono= $_POST['telefono'];
	 $direccion= $_POST['direccion'];
	 $localidad= $_POST['localidad'];
	 $provincia= $_POST['provincia'];
	 $email= $_POST['email'];
	 $tipo= $_POST['tipo'];
        $stmt = $dbh->prepare("update clientes set razonsocial='".$razonsocial."', cuit='".$cuit."',telefono='".$telefono."',direccion='".$direccion."',localidad='".$localidad."',provincia='".$provincia."',email='".$email."',tipo='".$tipo."',idsistema='".$idsistema."' where idcliente=".$codigo);
$stmt->execute();
   
echo '<div class="alert alert-success" role="alert">CLIENTE MODIFICADO CON EXITO</div>';
		

}
if(isset($_REQUEST['action']))
{
	if($_REQUEST["action"]=="del"){
$stmt = $dbh->prepare("delete from clientes where idcliente=".$_REQUEST['id']);
$stmt->execute();
   
echo '<div class="alert alert-warning" role="alert">CLIENTE ELIMINADO CON EXITO</div>';
}
}
include 'pages/clientes.tpl.php';
?>