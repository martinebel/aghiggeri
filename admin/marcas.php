<?php 
require '../db.php';
if(isset($_POST['action']))
{

	 $archivo = $_FILES['pic']['name'];
	$tipo = $_FILES['pic']['type'];
	$destino = "../img/m/".$archivo;
	if (copy($_FILES['pic']['tmp_name'],$destino)) {echo '<div class="alert alert-success" role="alert">IMAGEN GUARDADA CON EXITO</div>';}
	else {echo '<div class="alert alert-danger" role="alert">ERROR AL CARGAR EL ARCHIVO</div>';}

		

}

if(isset($_REQUEST['action']))
{
	if($_REQUEST['action']=="delete"){
	if(unlink("../img/m/".$_REQUEST['archivo']))
	{
		echo '<div class="alert alert-success" role="alert">IMAGEN ELIMINADA CON EXITO</div>';
	}
	else
	{
		echo '<div class="alert alert-danger" role="alert">ERROR AL ELIMINAR EL ARCHIVO</div>';
	}
	}
}

include 'pages/marcas.tpl.php';
?>