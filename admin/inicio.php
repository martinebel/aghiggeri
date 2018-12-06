<?php 
require '../db.php';
if(isset($_POST['action']))
{
	switch($_POST['action']){
	case "productos":
	 $codigo= $_POST['producto'];
        $stmt = $dbh->prepare("delete from paginicio");
$stmt->execute();
    foreach ($codigo as $ccodigo){
        $stmt = $dbh->prepare("insert into paginicio values(".$ccodigo.")");
$stmt->execute();

	}
	break;
	case "addbanner":
	$target_dir = "../img/";
			 $target_file = $target_dir . 'banner.jpg';
		 move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
	break;
	case "deletebanner":
	unlink('../img/banner.jpg');
	break;
    }


echo '<div class="alert alert-success" role="alert">PAGINA MODIFICADA CON EXITO</div>';
		

}

include 'pages/inicio.tpl.php';
?>