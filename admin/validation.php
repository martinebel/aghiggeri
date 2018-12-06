<?php
require '../db.php';
session_start();
$stmt = $dbh->prepare( "SELECT * from usuarios where usuario='".$_POST['usuario']."'");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			if($stmt->rowCount()==0){echo '<script>window.location.href="index.php?e=1";</script>';exit();}
foreach($result as $row)
		{

if($row['pass']==$_POST['password'])
{

 $_SESSION['idusuario'] = $row['codigo'];
 $_SESSION['nombreusuario'] = $row['usuario'];
 $_SESSION['tipousuario'] = $row['tipo'];
 
header('Location: dashboard.php');exit();
}
else
{
	header('Location: index.php?e=1');exit();
}
}

?>