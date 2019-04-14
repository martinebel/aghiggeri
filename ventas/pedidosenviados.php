
  <?php
  include 'header.php';
  ?>




  <div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
 <div class="col-md-12" style="padding: 0px;">
    <div class="row">
	<!------------------------>
	<div class="hidden-xs col-md-3">

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

		?>
		</div>
	 </div>
	</div>
  </div>

<!------------------------>


 <div class="col-md-9" style="padding: 0px;">


	<?php

		echo '<legend>Pedidos Enviados</legend>';
		$stmt2 = $dbh->prepare("select pedidos.*,clientes.razonsocial from pedidos inner join clientes on clientes.idcliente=pedidos.cliente where pedidos.idvendedor=".$_SESSION['cid']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
		foreach($result2 as $row)
		{
			echo '
			<div class="col-md-12" style="background:#fff;margin-bottom:5px;">
			<h3>'.$row["razonsocial"].'<a href="../impresion.php?id='.$row['id'].'" target="_blank" class="btn btn-lg btn-success pull-right">Imprimir</a></h3>

			<div class="pi-price">'.$row["fecha"].'</div>
			</div>';

		}

	?>



	 </div>

    </div>
	</div>
</div>





  <?php
  include 'footer.php';
  ?>
