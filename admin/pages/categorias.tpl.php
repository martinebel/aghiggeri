<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Categorias</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <a href="nuevacategoria.php" class="btn btn-success">Crear nueva Categoria</a>&nbsp;
				 <a href="excelcategoria.php" class="btn btn-success">Importar desde Excel</a>
				 </br>
				 </br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$padre=0;
								if(isset($_REQUEST['id'])){$padre=$_REQUEST['id'];}
								$stmt = $dbh->prepare("SELECT * from categorias where padre=".$padre);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nombre'].'</td>
                                        <td class="center"><a href="categorias.php?id='.$row['id'].'"  class="btn btn-default">Ver</a> <a href="editcategorias.php?id='.$row['id'].'"  class="btn btn-default">Editar</a></td>
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
	