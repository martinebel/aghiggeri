<?php
require '../db.php';
session_start();
$stmt2 = $dbh->prepare("select .* from temp_pedidos_header_vendedor where idpedido=".$_REQUEST['id']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll(); 
		foreach($result2 as $row)
		{
			$_SESSION['uid']=$row["clave"];
			$_SESSION['clienteid']=$row["idcliente"];
			$_SESSION['idpedido']=$row["idpedido"];
		}
header("Location: home.php");
?>