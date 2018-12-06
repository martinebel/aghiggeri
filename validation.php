<?php
require 'db.php';
session_start();
$stmt = $dbh->prepare( "SELECT * from clientes where cuit='".$_POST['cuit']."'");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			if($stmt->rowCount()==0){echo '<script>window.location.href="login.php?e=1";</script>';exit();}
foreach($result as $row)
		{

if($row['password']==$_POST['password'])
{

 $_SESSION['cid'] = $row['idcliente'];
 $_SESSION['cname'] = $row['razonsocial'];
 $_SESSION['cemail'] = $row['email'];
 $_SESSION['tipousuario'] = $row['tipo'];
 
header('Location: index.php');exit();
}
else
{
	header('Location: login.php?e=1');exit();
}
}

?>