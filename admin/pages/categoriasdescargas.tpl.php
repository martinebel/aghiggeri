<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grupos de Clientes</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				
				
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
								 <?php
				$stmt = $dbh->prepare("SELECT * from categoriadescargas order by idcategoria asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo '<tr><td>'.$row['idcategoria'].'</td><td>'.$row['nombre'].'</td><td><a href="categoriasdescargas.php?actions=delete&id='.$row['idcategoria'].'" class="btn btn-default">Eliminar</a></td></tr>';
		}
								?>
								</tbody>
								</table>
								<br>
								<form method="post" action="categoriasdescargas.php">
								<legend>Nueva Categoria</legend>
								<p>Nombre: <input type="text" class="form-control" name="nombre" required></p>
								<input type="hidden" name="action" value="guardar">
								<input type="submit" value="Guardar" class="btn btn-success">
								</form>
				</div>
				</div>
           
            </div>
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
	