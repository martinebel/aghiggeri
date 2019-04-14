<?php require '../db.php';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agustin Ghiggeri</title>
 <!-- Bootstrap Core CSS -->
    <link href="css/printer.css" rel="stylesheet">
</head>
<?php
$stmt = $dbh->prepare("select clientes.*,pedidos.fecha,pedidos.observaciones from pedidos inner join clientes on clientes.idcliente=pedidos.cliente where pedidos.id=".$_REQUEST['id']."");
        $stmt->execute();
		$result = $stmt->fetchAll();

		foreach($result as $row)
		{
			$cliente=$row['razonsocial'];
			$telefono=$row['telefono'];
			$mail=$row['email'];
			$direccion=$row['direccion'];
			$dni=$row['cuit'];
			$obs=$row['observaciones'];
			$fecha=$row['fecha'];
		}
		?>
<body>
<a id="btn2" href="#" onclick="impresion();">Imprimir</a>
<div class="book">
<div class="page">
<div class="subpage">
<div style="height:276mm;border: 1px solid;position:relative;">
<div class="row" style="height:7%;overflow:hidden;padding-top:5px">
<div class="col-md-4">
<img src="img/logo.png" style="width:155px;">
</div>
<div class="col-md-4" style="text-align:center">
<p><strong>Agustin Ghiggeri</strong></p>
<p style="font-size:10px">Av. 25 de Mayo 1164 | Resistencia, Chaco</p>
<p style="font-size:10px">Tel: 0362 – 4433100 - 4451555 | ventas@agustinghiggeri.com.ar</p>
</div>
<div class="col-md-4" style="text-align:right">
<p><strong>PEDIDO <?php echo str_pad($_REQUEST['id'],5,"0",STR_PAD_LEFT);?></strong></p>
<p style="font-size:10px">Creado <?php echo $fecha;?></p>
<p style="font-size:10px"></p>
</div>
</div>
<hr>
<div class="row" style="height:7%;overflow:hidden;padding-top:5px">
<div class="col-md-12">
<p ><strong>Razon Social: </strong><?php echo $cliente;?></p>
</div>
<div class="col-md-3">
<p ><strong>CUIT: </strong><?php echo $dni;?></p>
</div>
<div class="col-md-9">
<p ><strong>Direccion: </strong><?php echo $direccion;?></p>
</div>
<div class="col-md-6">
<p ><strong>Telefono: </strong><?php echo $telefono;?></p>
</div>
<div class="col-md-6">
<p><strong>E-mail: </strong><?php echo $mail;?></p>
</div>


</div>
<hr>
<div class="row" style="height:74%;overflow:hidden;padding-top:5px">
<div class="col-md-12">
<table id="cart" class="table table-hover table-condensed" style="width:100%">
    				<thead>
						<tr>
						<th style="width:10%;text-align:left">Codigo</th>
						<th style="width:10%;text-align:left">Cant.</th>
							<th style="width:60%;text-align:left">Producto</th>
							<th style="width:20%;text-align:right">Precio</th>
						</tr>
					</thead>
					<tbody>
					<?php
		//contar items del carrito
		$stmt = $dbh->prepare("select productos.*,detallepedidos.cant from detallepedidos inner join productos on productos.id=detallepedidos.idproducto where detallepedidos.idpedido=".$_REQUEST['id']."");
        $stmt->execute();
		$result = $stmt->fetchAll();
		$total=0;
		foreach($result as $row)
		{
			echo '<tr>
			<td data-th="Product">
							'.$row['codigo'].'
							</td>
							<td data-th="Product">
							'.$row['cant'].'
							</td>
							<td data-th="Product">
							'.$row['nombre'].' '.$row["marca"].' ('.$row["marcaauto"].' '.$row["modeloauto"].')
							</td>
							<td style="text-align:right">'.number_format(($row['precio']*$row['cant']),2,',','.').'</td>
						</tr>
					';
					$total+=($row['precio']*$row['cant']);
		}
		?>
					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td style="text-align:right;border-top:1px solid #ccc;"><strong>Total $<?php echo number_format($total,2,',','.');?></strong></td>

						</tr>
					</tfoot>
				</table>
				<hr>
				<p><strong>Observaciones: </strong><?php echo $obs;?></p>
				</div>
</div>
<div class="row" style="height:10%;overflow:hidden;padding-top:5px">
<div class="col-md-12">
<!--<p><strong>Comentarios Adicionales: </strong><?php echo $obs;?></p>-->
</div>
</div>

</div>
</div>
</div>
</div>
</div>
<!-- jQuery -->
    <script src="js/jquery.js"></script>
<script>
function impresion()
{

	$("#btn1").css("display","none");
	$("#btn2").css("display","none");
	 window.print();
	 	$("#btn1").css("display","inline");
	$("#btn2").css("display","inline");

}
</script>

</body>
</html>
