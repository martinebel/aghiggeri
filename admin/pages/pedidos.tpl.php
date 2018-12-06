<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-4">
                    <form method="GET" action="pedidos.php">
<?php
                    $filtro=0;
                    if(isset($_REQUEST['filtro']))
                    {
                        $filtro=$_REQUEST['filtro'];
                    }
                    ?>
                    <p>Vendedor
                    <select class="form-control" name="filtro" id="filtro">
                        <?php
                        echo '<option value="0" ';
            if($filtro==0){echo 'selected';}
            echo '>Todos</option>';
$stmt = $dbh->prepare("SELECT * from vendedores");
        $stmt->execute();
        $result = $stmt->fetchAll(); 
        foreach($result as $row)
        {
            echo '<option value="'.$row["idvendedor"].'" ';
            if($filtro==$row["idvendedor"]){echo 'selected';}
            echo '>'.$row["nombre"].'</option>';
        }
                        ?>
                    </select></p>
                </form>
                </div>
                <div class="col-lg-12">
                    
				 <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
                               

								$stmt = $dbh->prepare("SELECT pedidos.*,clientes.razonsocial,vendedores.nombre FROM pedidos inner join clientes on clientes.idcliente=pedidos.cliente 
                                    inner join vendedores on vendedores.idvendedor=pedidos.idvendedor ".($filtro!=0?'where pedidos.idvendedor='.$filtro:'')."
                                    order by pedidos.id desc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['fecha'].'</td>
                                        <td>'.$row['razonsocial'].'</td>
                                        <td><a href="../impresion.php?id='.$row['id'].'" target="_blank" class="btn btn-default">Imprimir</a>
                                            <span class="badge pull-right">'.$row['nombre'].'</span>
                                        </td>
                                    </tr>';
									if($tipo=="odd"){$tipo="even";}else{$tipo="odd";}
		}
								?>
								
								</tbody>
								</table>
				</div>
				</div>
           
            </div>
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
	    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
 <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

jQuery(function() {
    jQuery('#filtro').change(function() {

        this.form.submit();
    });
    
      
});
  
    </script>