<?php 
require '../db.php';
if(isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case "edit":
		$id=$_POST['id'];
		$nombre=$_POST['nombre'];
		$pass=$_POST['pass'];
		$tipo=$_POST['tipo'];
			$stmt = $dbh->prepare("update usuarios set usuario='".$nombre."', pass='".$pass."',tipo=".$tipo." where codigo=".$id);
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">USUARIO MODIFICADO CON EXITO</div>';
		break;
		case "nuevo":
		

		$nombre=$_POST['nombre'];
		$pass=$_POST['pass'];
		$tipo=$_POST['tipo'];
			$stmt = $dbh->prepare("insert into usuarios values(NULL,'".$nombre."','".$pass."',".$tipo.")");
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">USUARIO CREADO CON EXITO</div>';
		break;
	}
}

include 'pages/usuarios.tpl.php';
?>