<?php

class Funciones
{
    private $conexion;

    function __construct()
    {
        require('db.php');
        $this->conexion = $dbh;
    }

    function showPrices()
    {
    	 $stmt = $this->conexion->prepare("select mostrarprecio from config");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			if($row['mostrarprecio']=="0"){return false;}else{return true;}
		}
    }
	
	function esNuevo($idproducto)
	{
		$stmt = $this->conexion->prepare("SELECT * FROM productos WHERE `fechaalta` > timestampadd(day, -45, now()) and id=".$idproducto);
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		$totalitems=$stmt->rowCount();
		if($totalitems>0){return true;}else{return false;}
	}

    function esOferta($idproducto)
    {
      //obtener el codigo a partir del id
	  $codigo="";
	  $stmt = $this->conexion->prepare("select codigo from productos where id='".$idproducto."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$codigo=$row['codigo'];
		}
		
		$stmt = $this->conexion->prepare("select * from ofertas where idproducto='".$codigo."' and (fechadesde<='".date('Y-m-d')."' and fechahasta>='".date('Y-m-d')."')");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		$totalitems=$stmt->rowCount();
		if($totalitems>0){return true;}else{return false;}
    }

    function getFinOferta($idproducto)
    {
    	//obtener el codigo a partir del id
	  $codigo="";
	  $stmt = $this->conexion->prepare("select codigo from productos where id='".$idproducto."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$codigo=$row['codigo'];
		}
		
		$stmt = $this->conexion->prepare("select * from ofertas where idproducto='".$codigo."'");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$phpdate = strtotime( $row["fechahasta"] );
			return date( 'd-m-Y', $phpdate );
		}
    }
	
	function getTotalPedido($idpedido)
	{
		$total=0;
		$stmt = $this->conexion->prepare("select cant,precio from detallepedidos where idpedido='".$idpedido."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total+=($row['precio']*$row['cant']);
		}
		return $total;
	}

	function getTotalTempPedido($idpedido,$tipocliente)
	{
		$total=0;
		$stmt = $this->conexion->prepare("select temp_pedidos.cant,temp_pedidos.idproducto from temp_pedidos_header inner join temp_pedidos on temp_pedidos.id=temp_pedidos_header.idpedido where clave='".$idpedido."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total+=($this->getPrecio($row['idproducto'],$tipocliente)*$row['cant']);
		}
		return $total;
	}

	function getPedidosSinTerminar($idcliente,$uid)
	{
		$total=0;
		$stmt = $this->conexion->prepare("select count(idpedido) as total from temp_pedidos_header where idcliente='".$idcliente."' and clave <>'".$uid."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total=$row["total"];
		}
		return $total;
	}
	
	function getPrecio($idproducto,$tipocliente)
	{
		$descuento=0; $precio=0;$precioFinal=0;
		$codigo="";
	  $stmt = $this->conexion->prepare("select codigo,precio from productos where id='".$idproducto."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$codigo=$row['codigo'];
			$precio=$row['precio'];
		}

		//primero obtener el porcentaje de descuento para el grupo de cliente
		$stmt = $this->conexion->prepare("select  descuento from grupocliente where idgrupo=".$tipocliente);
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$descuento=$row['descuento'];
		}

		//aplicar el descuento
		$precioFinal = $precio - ($precio * ($descuento / 100));
 

		//ahora fijarse si esta en oferta y traer su descuento
		$stmt = $this->conexion->prepare("select * from ofertas where idproducto='".$codigo."' and (fechadesde<='".date('Y-m-d')."' and fechahasta>='".date('Y-m-d')."')");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$descuento=$row['porcentaje'];
			//aplicar descuento
		$precioFinal = $precioFinal - ($precioFinal * ($descuento / 100));
		}		
		
		
		//ahora traer el precio normal y aplicar los descuentos
		/*$stmt = $this->conexion->prepare("select  precio from productos where id=".$idproducto);
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$precio=$row['precio'];
		}
		//calcular y devolver el precio final
		$precioFinal=$precio-(($descuento*$precio)/100);*/
		
		return $precioFinal;
	}
	
	function getPrecioCant($idproducto,$tipocliente,$cantidad)
	{
		$descuento=0; $precio=0;
		$codigo="";
	  $stmt = $this->conexion->prepare("select codigo,precio from productos where id='".$idproducto."'");
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$codigo=$row['codigo'];
			$precio=$row['precio'];
		}
		
		//primero obtener el porcentaje de descuento para el grupo de cliente
		$stmt = $this->conexion->prepare("select  descuento from grupocliente where idgrupo=".$tipocliente);
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$descuento=$row['descuento'];
		}
		//aplicar el descuento
		$precioFinal = $precio - ($precio * ($descuento / 100));

		//ahora fijarse si esta en oferta y traer su descuento
		$stmt = $this->conexion->prepare("select * from ofertas where idproducto='".$codigo."' and (fechadesde<='".date('Y-m-d')."' and fechahasta>='".date('Y-m-d')."')");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$descuento=$row['porcentaje'];
			$precioFinal = $precioFinal - ($precioFinal * ($descuento / 100));
		}	
		

		//si iguala o supera la cantidad minima (que debe ser>0) aplicar el descuento x cantidad
		$stmt = $this->conexion->prepare("select cantoferta,descuento from productos where id='".$idproducto."'");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			if($row["cantoferta"]>0){ //si existe el descuento
				if($cantidad>=$row["cantoferta"]){ //si la cantidad en el carrito es >= a la oferta
			$descuento=$row['descuento'];
			$precioFinal = $precioFinal - ($precioFinal * ($descuento / 100));
			}
			}
		}			
		//ahora traer el precio normal y aplicar los descuentos
		/*$stmt = $this->conexion->prepare("select  precio from productos where id=".$idproducto);
		 $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$precio=$row['precio'];
		}
		//calcular y devolver el precio final
		$precioFinal=$precio-(($descuento*$precio)/100);*/
		//echo $precioFinal;
		return $precioFinal;
	}
}
?>