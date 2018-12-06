<?php 
require '../db.php';
if(isset($_POST['action']))
{

		$nombre=$_POST['nombre'];
		
		$stmt = $dbh->prepare("insert into categoriadescargas values (NULL,'".$nombre."');");
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">CATEGORIA CREADA CON EXITO</div>';
	
	
}

if(isset($_REQUEST['actions']))
{
	$stmt = $dbh->prepare("delete from categoriadescargas where idcategoria=".$_REQUEST['id']);
        $stmt->execute();
		echo '<div class="alert alert-success" role="alert">CATEGORIA ELIMINADA CON EXITO</div>';
}

include 'pages/categoriasdescargas.tpl.php';
?>