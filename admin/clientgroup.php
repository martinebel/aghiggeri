<?php 
require '../db.php';
if(isset($_POST['action']))
{

		$grupo1=$_POST['grupo1'];
		$grupo2=$_POST['grupo2'];
		$grupo3=$_POST['grupo3'];
			$stmt = $dbh->prepare("delete from grupocliente");
        $stmt->execute();
		$stmt = $dbh->prepare("insert into grupocliente values (1,'".$grupo1."'),(2,'".$grupo2."'),(3,'".$grupo3."');");
        $stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">GRUPOS MODIFICADOS CON EXITO</div>';
	
	
}

include 'pages/clientgroup.tpl.php';
?>