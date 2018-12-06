<?php 
require '../db.php';
if(isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case "edit":
		$id=$_POST['id'];
			$codigo=$_POST['codigo'];
			$nombre=$_POST['nombre'];
			$marca=$_POST['marca'];
			$precio=$_POST['precio'];
			$descripcion=$_POST['descripcion'];
			$marcaauto=$_POST['marcaauto'];
			$modeloauto=$_POST['modeloauto'];
			$desclarga=$_POST['desclarga'];
			$cantoferta=$_POST['cantoferta'];
			$descuento=$_POST['descuento'];
			$stock=$_POST['stock'];
			$stmt = $dbh->prepare("update productos set codigo='".$codigo."',nombre='".$nombre."',marca='".$marca."',precio='".$precio."',descripcion='".$descripcion."',marcaauto='".$marcaauto."',modeloauto='".$modeloauto."',desclarga='".$desclarga."',cantoferta='".$cantoferta."',descuento='".$descuento."', stock='".$stock."' where id=".$id);
        $stmt->execute();
		if (!empty($_FILES['pic']['name'])) {
			$target_dir = "../img/p/";
			 $target_file = $target_dir . $_FILES["pic"]["name"];
		 move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
		 		 $stmt = $dbh->prepare("update productos set imagen='".$_FILES["pic"]["name"]."' where id=".$id);
		  $stmt->execute();
		}
		echo '<div class="alert alert-success" role="alert">PRODUCTO MODIFICADO CON EXITO</div>';
		break;
		case "nuevo":
		$target_dir = "../img/p/";

		$codigo=$_POST['codigo'];
			$nombre=$_POST['nombre'];
			$marca=$_POST['marca'];
			$precio=$_POST['precio'];
			$descripcion=$_POST['descripcion'];
			$marcaauto=$_POST['marcaauto'];
			$modeloauto=$_POST['modeloauto'];
			$desclarga=$_POST['desclarga'];
			$stmt = $dbh->prepare("insert into productos values(NULL,'".$codigo."','".$nombre."','".$marca."','".$precio."',NULL,,'".$descripcion."','".$marcaauto."',,'".$modeloauto."','','".$desclarga."')");
        $stmt->execute();
		 $idcat=$dbh->lastInsertId(); 
		 $target_file = $target_dir . $_FILES["pic"]["name"];
		 move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
		 $stmt = $dbh->prepare("update productos set imagen='".$_FILES["pic"]["name"]."' where id=".$idcat);
		  $stmt->execute();
		echo '<div class="alert alert-success" role="alert">PRODUCTO CREADO CON EXITO</div>';
		break;
	}
}

include 'pages/productos.tpl.php';
?>