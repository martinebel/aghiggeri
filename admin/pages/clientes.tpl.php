<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Clientes</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <a href="excelclientes.php" class="btn btn-success">Importar desde Excel</a>
				 </br>
				 </br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Razon Social</th>
                                        <th>CUIT</th>
										<th>Telefono</th>
										<th>Email</th>
										<th>Cod. Sistema</th>
										<th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$padre=0;
								
								$stmt = $dbh->prepare("SELECT * from clientes");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['idcliente'].'</td>
                                        <td>'.$row['razonsocial'].'</td>
										 <td>'.$row['cuit'].'</td>
										 <td>'.$row['telefono'].'</td>
										  <td>'.$row['email'].'</td>
										   <td>'.$row['idsistema'].'</td>
                                        <td class="center"><a href="editcliente.php?id='.$row['idcliente'].'"  class="btn btn-default">Editar</a></td>
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