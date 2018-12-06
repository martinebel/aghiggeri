<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-stack-overflow fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<?php
					$stmt = $dbh->prepare("SELECT count(*) as total FROM `pedidos`");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total=$row['total'];
		}
		?>
                                    <div class="huge"><?php echo $total;?></div>
                                    <div>Pedidos en Total</div>
                                </div>
                            </div>
                        </div>
                        <a href="pedidos.php">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Pedidos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<?php
					$stmt = $dbh->prepare("SELECT count(*) as total FROM `pedidos` WHERE MONTH(fecha) = MONTH(CURRENT_DATE())");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total=$row['total'];
		}
		?>
                                    <div class="huge"><?php echo $total;?></div>
                                    <div>Pedidos este mes</div>
                                </div>
                            </div>
                        </div>
                        <a href="pedidos.php">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Pedidos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<?php
					$stmt = $dbh->prepare("SELECT count(*) as total FROM `productos`");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total=$row['total'];
		}
		?>
                                    <div class="huge"><?php echo $total;?></div>
                                    <div>Productos</div>
                                </div>
                            </div>
                        </div>
						<?php
						if( $_SESSION['tipousuario']=="1"){
						echo '
                        <a href="productos.php">
                            <div class="panel-footer">
							
                                <span class="pull-left">Ver Productos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>';}?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-alt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <?php
					$stmt = $dbh->prepare("SELECT count(*) as total FROM `categorias`");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$total=$row['total'];
		}
		?>
                                    <div class="huge"><?php echo $total;?></div>
                                    <div>Categorias</div>
                                </div>
                            </div>
                        </div><?php
						if( $_SESSION['tipousuario']=="1"){
						echo '
                        <a href="categorias.php">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Categorias</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>';}?>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Pedidos en los ultimos 6 meses
                            <div class="pull-right">
                               
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-shopping-cart fa-fw"></i> Ultimos Pedidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
							 <?php
					$stmt = $dbh->prepare("SELECT clientes.razonsocial,pedidos.* from `pedidos` inner join clientes on pedidos.cliente=clientes.idcliente order by id desc limit 8");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo '<a href="#" class="list-group-item">
                                    '.$row['razonsocial'].'
                                    <span class="pull-right text-muted small"><em>'.date_format(new DateTime($row['fecha']),'d-m-Y').'</em>
                                    </span>
                                </a>';
		}
		?>
                            </div>
                            <!-- /.list-group -->
                            <a href="pedidos.php" class="btn btn-default btn-block">Ver Pedidos</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   

                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
  <script>
  $(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [
			  <?php
					$stmt = $dbh->prepare("SELECT count(*) as total ,MONTH(fecha) as mes FROM pedidos WHERE fecha > (NOW() - INTERVAL 6 MONTH) group by MONTH(fecha)");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		$datos="";
		foreach($result as $row)
		{
			$datos.= "{a: '".date('F', mktime(0, 0, 0, $row['mes'], 10))."',y: ".$row['total']."},";
		}
		$datos=substr($datos,0,-1);
		echo $datos;
		?>
            
         ],
         xkey: 'a',
  ykeys: 'y',
  labels: ['Pedidos'],
  hideHover: true,
  parseTime: false,
        pointSize: 2
    });
    
});
  </script>