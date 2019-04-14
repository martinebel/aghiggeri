<?php
require '../db.php';
include_once '../functions.php';
$funciones = new Funciones();
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agustin Ghiggeri</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
	<?php
							$stmt = $dbh->prepare("SELECT clientes.*,pedidos.* from pedidos inner join clientes on clientes.idcliente=pedidos.cliente where pedidos.id=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$tipousuario=$row['tipo'];
			echo '<div style="max-width:49%;float:left;"><p><strong>PEDIDO NRO '.str_pad($row['id'],5,"0",STR_PAD_LEFT).'</strong></p>
			<p><strong>FECHA: </strong>'.$row['fecha'].'</p>
			<p><strong>CLIENTE: </strong>'.$row['razonsocial'].'</p>
			<p><strong>EMAIL: </strong>'.$row['email'].'</p>
			</div>
			<div style="max-width:49%;float:right;"><p><strong>TELEFONO: </strong>'.$row['telefono'].'</p>
			<p><strong>DIRECCION: </strong>'.$row['direccion'].'</p>
			<p><strong>LOCALIDAD: </strong>'.$row['localidad'].'</p>
			<p><strong>PROVINCIA: </strong>'.$row['provincia'].'</p>
			</div>';
		}
		?>


	 <table width="100%" style="text-align:left;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
										 <th>Cant</th>
										  <th>PU</th>
                                        <th>SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";

								$stmt = $dbh->prepare("SELECT productos.*,detallepedidos.cant from detallepedidos inner join productos on productos.id=detallepedidos.idproducto where idpedido=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['codigo'].'</td>
                                        <td>'.$row['nombre'].'</td>
										<td>'.$row['cant'].'</td>
                                        <td>$'.number_format($funciones->getPrecio($row['id'],$tipousuario),2,',','.').'</td>
										<td>$'.number_format($funciones->getPrecio($row['id'],$tipousuario)*$row['cant'],2,',','.').'</td>
                                    </tr>';
									if($tipo=="odd"){$tipo="even";}else{$tipo="odd";}
		}
								?>

								</tbody>
								</table>
	</body>
	</html>
	<script>
window.print();
window.onfocus=function(){ window.close();}
	</script>
