<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Descargas Clientes</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 
				
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       
                                        <th>Nombre</th>
										<th>Archivo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$tipo="odd";
								$stmt = $dbh->prepare("SELECT * from descargas");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo ' <tr class="'.$tipo.'">
                                       
                                        <td>'.$row['nombre'].'</td>
										 <td>'.$row['archivo'].'</td>
                                        <td class="center"><a href="descClientes.php?action=delete&id='.$row['iddescarga'].'"  class="btn btn-default">Eliminar</a></td>
                                    </tr>';
									if($tipo=="odd"){$tipo="even";}else{$tipo="odd";}
		}
								?>
								
								</tbody>
								</table>
								
								<legend>Nueva Descarga</legend>
								<form action="descClientes.php" method="post" enctype="multipart/form-data">
								<div class="row">
								<div class="col-md-6">
<p>Nombre de la Descarga</p>
<input type="text" name="nombre" class="form-control" required>
</div>
								<div class="col-md-6">
<p>Archivo</p>
<input type="file" required name="excel" />
</div>
</div>
<div class="row">
<div class="col-md-6">
<p>Categoria</p>
<select name="categoria" class="form-control" required>
<?php
$stmt = $dbh->prepare("SELECT * from categoriadescargas order by idcategoria asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo '<option value="'.$row['idcategoria'].'">'.$row['nombre'].'</option>';
		}
?>
</select>
</div>

								<div class="col-md-6">
								<p>&nbsp;</p>
								<input type="hidden" name="action" value="guardar">
<input type="submit" value="Guardar" class="btn btn-success">
</div>
								</div>
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
	