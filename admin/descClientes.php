<?php 
require '../db.php';
if(isset($_POST['action']))
{
	
		$target_dir = "../descargas/";
			 $target_file = $target_dir . $_FILES["excel"]["name"];
		 move_uploaded_file($_FILES["excel"]["tmp_name"], $target_file);

		$nombre=$_POST['nombre'];
		$categoria=$_POST['categoria'];
			$stmt = $dbh->prepare("insert into descargas values(NULL,'".$nombre."','". $_FILES["excel"]["name"]."',".$categoria.")");
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">ARCHIVO GUARDADO CON EXITO</div>';

}

if(isset($_REQUEST['action']))
{
	if($_REQUEST['action']=="delete")
{
	$stmt = $dbh->prepare("delete from descargas where iddescarga=".$_REQUEST['id']);
        $stmt->execute();
		
}
}

include 'pages/descClientes.tpl.php';
?>