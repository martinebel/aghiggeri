<?php
require 'db.php';
$uid=$_REQUEST['clave'];
include_once 'functions.php';
$funciones = new Funciones();
	   
 function generateSession()
 {
	  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
 }

switch($_REQUEST['action'])
{
	case 'addCart':
	//crear el header si no existe
	$stmt=$dbh->prepare("select * from temp_pedidos_header where clave='".$uid."'");
	 $stmt->execute();
	 $result2 = $stmt->fetchAll(); 
	 if($stmt->rowCount()>0)
	 {
		foreach($result2 as $row2)
		{
			$idpedido=$row2["idpedido"];
		}
	 }
	 else
	 {

	 	$stmt=$dbh->prepare("insert into temp_pedidos_header (idpedido,fecha,idcliente,clave,total) values (NULL,'".date('Y-m-d')."','".$_REQUEST['cid']."','".$uid."',0)");
	 	$stmt->execute();
	 	$idpedido=$dbh->lastInsertId(); 
	 }
	 //insertar detalle
	 $stmt = $dbh->prepare("insert into temp_pedidos (id,idproducto,itemno,cant) values ('".$idpedido."',".$_REQUEST['id'].",NULL,".$_REQUEST['cant'].")");
        $stmt->execute();
		$ultimo=$dbh->lastInsertId(); 
		 $stmt = $dbh->prepare("select * from productos where id=".$_REQUEST['id']);
        $stmt->execute();
		$result2 = $stmt->fetchAll(); 
		$output_array=array();
		foreach($result2 as $row2)
		{
			$output_array[] = array( 'nombre' =>$row2['nombre'],'id'=>$ultimo,'precio' =>$row2['precio']);
	
		}

		//obtener tipo cliente
		$tipocliente=1;
 		$stmt = $dbh->prepare("select * from clientes where idcliente=".$_REQUEST['cid']);
        $stmt->execute();
		$result2 = $stmt->fetchAll(); 
		foreach($result2 as $row2)
		{
			$tipocliente=$row2["tipo"];
		}
		//actualizar total
		$stmt=$dbh->prepare("update temp_pedidos_header set total='".$funciones->getTotalTempPedido($uid,$tipocliente)."' where idpedido=".$idpedido);
		$stmt->execute();

		//devolver nombre del producto insertado
		echo json_encode( $output_array );
	break;
	
	case 'removeCart':
	$stmt = $dbh->prepare("select productos.* from temp_pedidos inner join productos on productos.id=temp_pedidos.idproducto where itemno=".$_REQUEST['id']);
        $stmt->execute();
		$result2 = $stmt->fetchAll(); 
		$output_array=array();
		foreach($result2 as $row2)
		{
			$output_array[] = array( 'nombre' =>$row2['nombre'],'precio' =>$row2['precio']);
	
		}
	 $stmt = $dbh->prepare("delete from temp_pedidos where itemno=".$_REQUEST['id']);
        $stmt->execute();

        $stmt=$dbh->prepare("select * from temp_pedidos_header where clave='".$uid."'");
	 $stmt->execute();
	 $result2 = $stmt->fetchAll(); 
		foreach($result2 as $row2)
		{
			$idpedido=$row2["idpedido"];
			$idcliente=$row["idcliente"];
		}
	 

        //obtener tipo cliente
		$tipocliente=1;
 		$stmt = $dbh->prepare("select * from clientes where idcliente=".$idcliente);
        $stmt->execute();
		$result2 = $stmt->fetchAll(); 
		foreach($result2 as $row2)
		{
			$tipocliente=$row2["tipo"];
		}
		//actualizar total
		$stmt=$dbh->prepare("update temp_pedidos_header set total='".$funciones->getTotalTempPedido($uid,$tipocliente)."' where idpedido=".$idpedido);
		$stmt->execute();
		 
		echo json_encode( $output_array );
	break;
	
	case 'emptyCart':
	 $stmt=$dbh->prepare("select * from temp_pedidos_header where clave='".$uid."'");
	 $stmt->execute();
	 $result2 = $stmt->fetchAll(); 
		foreach($result2 as $row2)
		{
			$idpedido=$row2["idpedido"];
		}

	$stmt = $dbh->prepare("delete from temp_pedidos where id='".$idpedido."'");
        $stmt->execute();
        $stmt = $dbh->prepare("delete from temp_pedidos_header where idpedido='".$idpedido."'");
        $stmt->execute();
	break;

	case 'reloadCart':
	//si hay un carrito ahora, cambiarle el ID
	if($funciones->getTotalTempPedido($_REQUEST['uid'],1)>0)
	{
		$stmt = $dbh->prepare("update temp_pedidos_header set clave='".generateSession()."' where clave='".$_REQUEST['uid']."'");
        $stmt->execute();
        echo "update temp_pedidos_header set clave='".generateSession()."' where clave='".$_REQUEST['uid']."'";
	}
	//renombrar el pedido seleccionado con el ID actual
	 $stmt = $dbh->prepare("update temp_pedidos_header set clave='".$_REQUEST['uid']."' where clave='".$_REQUEST['clave']."'");
        $stmt->execute();
        echo "update temp_pedidos_header set clave='".$_REQUEST['uid']."' where clave='".$_REQUEST['clave']."'";
	
	break;

}
?>