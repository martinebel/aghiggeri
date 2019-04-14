
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
<form method="POST"	 action="home.php">
<input type="hidden" name="action" value="nuevopedido">
<input type="hidden" name="idcliente" id="idcliente">
<div class="col-md-8 col-md-offset-1">
                <div class="login-panel panel panel-default">

                    <div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Busque un Cliente"  id="cuit" type="text" autofocus required>
                                </div>


                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Crear Pedido">
                                <br>

                                    <p>No encuentra el cliente? <a href="nuevocliente.php">Haga click aqui para crear uno</a></p>

                            </fieldset>

                    </div>
                </div>
            </div>
</form>
</div>

    </div>
	</div>
</div>





  <?php
  include 'footer.php';
  ?>

<script>
 (function($){
  $( "#cuit" ).autocomplete({
    source: "ajax_search_cliente.php",
      minLength: 2,
      select: function( event, ui ) {
		$("#idcliente").val(ui.item.id);
      }
  });
})(jQuery);
</script>
