<?php
require '../db.php';
session_start();
$stmt = $dbh->prepare( "SELECT * from vendedores where usuario='".$_POST['cuit']."'");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			if($stmt->rowCount()==0){echo '<script>window.location.href="index.php?e=1";</script>';exit();}
foreach($result as $row)
		{

if($row['pass']==$_POST['password'])
{

 $_SESSION['cid'] = $row['idvendedor'];
 $_SESSION['cname'] = $row['nombre'];
 $_SESSION['tipousuario'] = "1";

header('Location: home.php');exit();
}
else
{
	header('Location: index.php?e=1');exit();
}
}

?>