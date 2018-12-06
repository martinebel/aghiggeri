<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Usuarios</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <a href="nuevousuario.php" class="btn btn-success">Crear nuevo usuario</a>&nbsp;
				 </br>
				 </br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
										<th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$stmt = $dbh->prepare("SELECT * from usuarios");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['codigo'].'</td>
                                        <td>'.$row['usuario'].'</td>
										<td>'.($row['tipo']=="1"?'Administrador':'Vendedor').'</td>
                                        <td class="center"><a href="editusuario.php?id='.$row['codigo'].'"  class="btn btn-default">Editar</a></td>
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
	