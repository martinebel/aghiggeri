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
		$usuario=$_POST['usuario'];
			$stmt = $dbh->prepare("update vendedores set nombre='".$nombre."', pass='".$pass."',usuario=".$usuario." where idvendedor=".$id);
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">VENDEDOR MODIFICADO CON EXITO</div>';
		break;
		case "nuevo":
		

		$nombre=$_POST['nombre'];
		$pass=$_POST['pass'];
		$usuario=$_POST['usuario'];
			$stmt = $dbh->prepare("insert into vendedores values(NULL,'".$nombre."','".$usuario."',".$pass.")");
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">VENDEDOR CREADO CON EXITO</div>';
		break;
	}
}

include 'pages/vendedores.tpl.php';
?>