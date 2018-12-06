<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Vendedores</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <a href="nuevovendedor.php" class="btn btn-success">Crear nuevo vendedor</a>&nbsp;
				 </br>
				 </br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
										<th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$stmt = $dbh->prepare("SELECT * from vendedores");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['idvendedor'].'</td>
                                        <td>'.$row['nombre'].'</td>
										<td>'.$row['usuario'].'</td>
                                        <td class="center"><a href="editvendedor.php?id='.$row['idvendedor'].'"  class="btn btn-default">Editar</a></td>
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
	