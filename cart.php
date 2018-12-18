  <?php
  include 'header.php';

  ?>
    <style>
	.table>tbody>tr>td, .table>tfoot>tr>td{
    vertical-align: middle;
}
@media screen and (max-width: 600px) {
    table#cart tbody td .form-control{
		width:20%;
		display: inline !important;
	}
	.actions .btn{
		width:36%;
		margin:1.5em 0;
	}

	.actions .btn-info{
		float:left;
	}
	.actions .btn-danger{
		float:right;
	}

	table#cart thead { display: none; }
	table#cart tbody td { display: block; padding: .6rem; min-width:320px;}
	table#cart tbody tr td:first-child { background: #333; color: #fff; }
	table#cart tbody td:before {
		content: attr(data-th); font-weight: bold;
		display: inline-block; width: 8rem;
	}



	table#cart tfoot td{display:block; }
	table#cart tfoot td .btn{display:block;}
	}

p.no-margin{margin:14px 0 14px;;vertical-align:middle;}

body {

  font-family: arial, sans-serif;
  line-height: 100%;
}

.steps{text-align:center;}

.steps  ul {
    margin: 0;
    padding: 0;
}
  .steps   li {
      font-size: 16px;
      position: relative;
      padding-right: 20px;
      display: inline-block;
      color: #999;
      line-height: 40px;
      padding-left: 60px;
}
      .steps li:last-child { padding-right: 0; }

      .normal:before {
        left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%;

      }
.is-active:before,.is-current:before {left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%; border-color: #69a53a; }
 .is-active  span:before { display: block; }

      span:before {
          font-family: FontAwesome;
          font-style: normal;
          font-weight: normal;
          line-height: 1;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;

          color: #fff;
          padding: 0;
          left: -10px;
          bottom: -5px;
          display: none;
          font-size: 10px;
          content: "\f00c";
          text-align: center;
          position: absolute;
          background: #69a53a;
             width: 16px;
    height: 16px;
    border: 3px solid #69a53a;

          border-radius:100%;
        }
</style>
    <div class="container" style=" padding-top: 20px;">
	<div class="steps">
  <ul>
    <li class="is-current"><span>Confirmar Pedido</span></li>
    <li class="normal"><span>Datos del Cliente</span></li>
    <li class="normal"><span>Finalizado</span></li>
  </ul>
</div>
<br>
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
					<form method="post" action="cart.php" id="formCart">
					<?php
		//contar items del carrito
		$stmt = $dbh->prepare("select productos.*,temp_pedidos.itemno,temp_pedidos.cant from temp_pedidos_header
		inner join temp_pedidos on temp_pedidos.id=temp_pedidos_header.idpedido
		inner join productos on productos.id=temp_pedidos.idproducto where temp_pedidos_header.clave='".$_SESSION['uid']."'");
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
				$path_parts = pathinfo('./img/p/'.$row['imagen']);
				$file=$path_parts['filename'];
				//probar si existe con extension mayuscula
				$ext = strtoupper($path_parts['extension']);
				if(file_exists('./img/p/'.$file.".".$ext))
				{
					echo '<img src="./img/p/'.$file.".".$ext.'" onerror="this.src=\'default.jpeg\';"  class="img-responsive" style="width:50px;" />';
				}
				elseif(file_exists('./img/p/'.$file.".".strtolower($ext)))
				{
					echo '<img src="./img/p/'.$file.".".strtolower($ext).'" onerror="this.src=\'default.jpeg\';" class="img-responsive" style="width:50px;" />';
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
										<p class="no-margin">('.$row['codigo'].') '.$row['nombre'].' '.$row['marca'].'</p>
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
		?>
		<input type="hidden" name="action" value="refreshCart">
				</form>
					</tbody><tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total $<?php echo number_format($total,2,',','.');?></strong></td>

						</tr>
						<tr>
							<td><button onclick="window.history.back()" class="btn btn-warning"><i class="fa fa-angle-left"></i> Seguir Comprando</button>&nbsp;
								<a href="#" onclick="emptyCart();" class="btn btn-danger"><i class="fa fa-times"></i> Vaciar Carrito</a>&nbsp;
								<a href="#" onclick='$("#formCart").submit();' class="btn btn-info"><i class="fa fa-refresh"></i> Actualizar</a>
							</td>
							<td  colspan="2"><small>Subtotal Neto IVA Incluido</small></td>
							<td class="hidden-xs"><strong>Total $<?php echo number_format($total,2,',','.');?></strong></td>
							<?php
							if($stmt->rowCount()>0){echo '<td><a href="checkout-step1.php" class="btn btn-success btn-block">Confirmar Pedido <i class="fa fa-angle-right"></i></a></td>';}?>
						</tr>
					</tfoot>
				</table>


				</div>

      <?php
  include 'footer.php';
  ?>
