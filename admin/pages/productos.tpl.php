<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Productos</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <a href="nuevoproducto.php" class="btn btn-success">Crear nuevo Producto</a>&nbsp;
				 <a href="excelproducto.php" class="btn btn-success">Importar desde Excel</a>
				 </br>
				 </br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Marca</th>
										<th>Precio</th>
										<th>Auto</th>
										<th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$padre=0;
								
								$stmt = $dbh->prepare("SELECT * from productos");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['codigo'].'</td>
                                        <td>'.$row['nombre'].'</td>
										 <td>'.$row['marca'].'</td>
										 <td>$'.$row['precio'].'</td>
										 <td>'.$row['marcaauto'].' '.$row['modeloauto'].'</td>
                                        <td class="center"><a href="editproducto.php?id='.$row['id'].'"  class="btn btn-default">Editar</a></td>
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
	<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
 <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>