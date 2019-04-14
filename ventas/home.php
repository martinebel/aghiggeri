
  <?php
  include 'header.php';
  ?>




  <div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
 <div class="col-md-12" style="padding: 0px;">
    <div class="row">
	<!------------------------>
	<div class="hidden-xs col-md-3">
    <?php
    	if( isset($_SESSION['uid']) ){
    echo ' <div class="well" style="padding: 8px 0;">
          <div style=" overflow-x: hidden;">
              <ul class="nav nav-list">';

              $stmt = $dbh->prepare("select * from clientes where idcliente=".$_SESSION['clienteid']);
                  $stmt->execute();
          		$result = $stmt->fetchAll();
          		foreach($result as $row)
          		{
echo '  <li><label class="tree-toggler nav-header"><i class="fa fa-user"></i> '.$row["razonsocial"].'</label>
<ul class="nav nav-list tree">
 <li><i class="fa fa-phone"></i> '.$row["telefono"].'</li>
 <li><i class="fa fa-map-marker"></i> '.$row["direccion"].' '.$row["localidad"].' '.$row["provincia"].'</li>
</ul>';
              }


echo '</li>
  </ul>
  </div>
  </div>';
}
?>
	 <div id="wrapperMenu">

	       <div class="panel-group" id="menu-dashboard">
  <div class="panel panel-default">
  <?php
		if( !isset($_SESSION['uid']) ){
			echo '
			<div class="panel-heading">
      <h4 class="panel-title">
        <a href="nuevopedido.php">
       <span class="icon-link2"></span>Nuevo Pedido</a>
      </h4>
    </div>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="nuevocliente.php">
       <span class="icon-link2"></span>Nuevo Cliente</a>
      </h4>
    </div>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="home.php">
       <span class="icon-link2"></span>Pedidos Pendientes</a>
      </h4>
    </div>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="pedidosenviados.php">
       <span class="icon-link2"></span>Pedidos Enviados</a>
      </h4>
    </div>';
		}
		else
		{

		$stmt = $dbh->prepare("select * from categorias where padre=0");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
		echo '<div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#menu-dashboard" href="#collapse'.$row['id'].'">
       <span class="icon-link2"></span>
                        '.$row['nombre'].'<span class="caret"></span></a>
      </h4>
    </div>
	<div id="collapse'.$row['id'].'" class="panel-collapse collapse"> <ul class="list-group">
                       ';
                             $stmt2 = $dbh->prepare("select * from categorias where padre=".$row['id']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
		foreach($result2 as $row2)
		{
			echo ' <li><a href="productlist.php?id='.$row2['id'].'">'.strtoupper($row2['nombre']).'</a></li>';

		}
                    echo '</ul>
  </div>';
		}
	}
		?>
		</div>
	 </div>
	</div>
  </div>

<!------------------------>


 <div class="col-md-9" style="padding: 0px;">


	<?php
	if( !isset($_SESSION['uid']) ){
		echo '<legend>Pedidos Pendientes</legend>';
		$stmt2 = $dbh->prepare("select temp_pedidos_header_vendedor.*,clientes.razonsocial from temp_pedidos_header_vendedor inner join clientes on clientes.idcliente=temp_pedidos_header_vendedor.idcliente where temp_pedidos_header_vendedor.idvendedor=".$_SESSION['cid']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
		foreach($result2 as $row)
		{
			echo '
			<div class="col-md-12" style="background:#fff;margin-bottom:5px;">
			<h3>'.$row["razonsocial"].'<a href="#" onclick="reloadTemp('.$row['idpedido'].');" class="btn btn-lg btn-success pull-right">Continuar</a></h3>

			<div class="pi-price">'.$row["fecha"].'</div>
			</div>';

		}
	}
	else
	{
		$stmt2 = $dbh->prepare("select temp_pedidos_header_vendedor.*,clientes.razonsocial from temp_pedidos_header_vendedor inner join clientes on clientes.idcliente=temp_pedidos_header_vendedor.idcliente where temp_pedidos_header_vendedor.idpedido= ".$_SESSION['idpedido']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
		foreach($result2 as $row)
		{
		echo '
		<table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr>
							<th style="width:60%">Producto</th>
							<th style="width:10%">Cant.</th>
							<th style="width:10%">PU</th>
							<th style="width:10%">SubTotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
					<form method="post" action="home.php" id="formCart">';

		//contar items del carrito
		$stmt = $dbh->prepare("select productos.*,temp_pedidos_vendedor.itemno,temp_pedidos_vendedor.cant from temp_pedidos_header_vendedor
		inner join temp_pedidos_vendedor on temp_pedidos_vendedor.id=temp_pedidos_header_vendedor.idpedido
		inner join productos on productos.id=temp_pedidos_vendedor.idproducto where temp_pedidos_header_vendedor.idpedido='".$_SESSION['idpedido']."'");
        $stmt->execute();
		$result = $stmt->fetchAll();
		$total=0;
		if($stmt->rowCount()==0){echo '<tr><td>No hay productos en su carrito!</p></td></tr>';}
		foreach($result as $row)
		{
			$preciofinal=$funciones->getPrecioCant($row['id'],$_SESSION['tipousuario'],$row['cant']);
			echo '<tr>
							<td data-th="Producto">
								<div class="row">
									<div class="col-sm-2 hidden-xs">';
									   if(!empty($row["imagen"]))
			{
				$path_parts = pathinfo('../img/p/'.$row['imagen']);
				$file=$path_parts['filename'];
				//probar si existe con extension mayuscula
				$ext = strtoupper($path_parts['extension']);
				if(file_exists('../img/p/'.$file.".".$ext))
				{
					echo '<img src="../img/p/'.$file.".".$ext.'" onerror="this.src=\'default.jpeg\';"  class="img-responsive" style="width:50px;" />';
				}
				elseif(file_exists('../img/p/'.$file.".".strtolower($ext)))
				{
					echo '<img src="../img/p/'.$file.".".strtolower($ext).'" onerror="this.src=\'default.jpeg\';" class="img-responsive" style="width:50px;" />';
				}
				else
				{
					echo '<img src="default.jpeg"  class="img-responsive" style="width:50px;" />';
				}
			}
			else
			{
				echo '<img src="default.jpeg"  class="img-responsive" style="width:50px;" />';
			}


									echo '</div>
									<div class="col-sm-10">
										<p class="no-margin">'.$row['nombre'].'</p>
										<input type="hidden" name="codigo[]" value="'.$row['itemno'].'">
									</div>
								</div>
							</td>
							<td data-th="Cant"><input name="cant[]" type="number" value="'.$row['cant'].'" min="1" max="100" /></td>
							<td data-th="PU">$'.number_format($preciofinal,2,',','.').'</td>
							<td data-th="SubTotal">$'.number_format($preciofinal*$row['cant'],2,',','.').'</td>

							<td class="actions" data-th="">
								<button class="btn btn-danger btn-sm" onclick="removeCart('.$row['itemno'].');"><i class="fa fa-trash-o"></i></button>
							</td>
						</tr>
					';
					$total+=($preciofinal*$row['cant']);
		}

		echo '<input type="hidden" name="action" value="refreshCart">
				</form>
					</tbody><tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total $<?php echo number_format($total,2,',','.');?></strong></td>

						</tr>
						<tr>
							<td><button onclick="continuarLuego('.$_SESSION["idpedido"].');" class="btn btn-warning">Continuar Luego</button>&nbsp;
								<a href="#" onclick="emptyCart();" class="btn btn-danger"><i class="fa fa-times"></i> Eliminar Pedido</a>&nbsp;
								<a href="#" onclick=\'$("#formCart").submit();\' class="btn btn-info"><i class="fa fa-refresh"></i> Actualizar</a>
							</td>
							<td  colspan="2"><small>Subtotal Neto Sin Impuestos</small></td>
							<td class="hidden-xs"><strong>$';
							 echo number_format($total,2,',','.');
							 echo '</strong></td>';

							if($stmt->rowCount()>0){echo '<td><a href="checkout-step1.php" class="btn btn-success btn-block">Confirmar Pedido <i class="fa fa-angle-right"></i></a></td>';}
						echo '</tr>
					</tfoot>
				</table>';
	}
	}
	?>



	 </div>

    </div>
	</div>
</div>





  <?php
  include 'footer.php';
  ?>
