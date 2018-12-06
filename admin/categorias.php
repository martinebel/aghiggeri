<?php 
require '../db.php';
if(isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case "edit":
		$id=$_POST['id'];
		$nombre=$_POST['nombre'];
		$padre=$_POST['padre'];
			$stmt = $dbh->prepare("update categorias set nombre='".$nombre."', padre=".$padre." where id=".$id);
        $stmt->execute();
		if (!empty($_FILES['pic']['name'])) {
			$target_dir = "../img/c/";
			 $target_file = $target_dir . $id.'.'.pathinfo(basename($_FILES["pic"]["name"]),PATHINFO_EXTENSION);
		 move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
		}
		echo '<div class="alert alert-success" role="alert">CATEGORIA MODIFICADA CON EXITO</div>';
		header('Location: categorias.php?id='.$padre);
		exit();
		break;
		case "nuevo":
		$target_dir = "../img/c/";

		$nombre=$_POST['nombre'];
		$padre=$_POST['padre'];
			$stmt = $dbh->prepare("insert into categorias values(NULL,'".$nombre."',".$padre.")");
        $stmt->execute();
		 $idcat=$dbh->lastInsertId(); 
		 $target_file = $target_dir . $idcat.'.'.pathinfo(basename($_FILES["pic"]["name"]),PATHINFO_EXTENSION);
		 move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
		echo '<div class="alert alert-success" role="alert">CATEGORIA CREADA CON EXITO</div>';
		header('Location: categorias.php?id='.$padre);
		exit();
		break;
	}
}

include 'pages/categorias.tpl.php';
?>