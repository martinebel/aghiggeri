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
				 <?php
				 $vgrupo1=0;
				 $vgrupo2=0;
				 $vgrupo3=0;
								
								$stmt = $dbh->prepare("SELECT * from grupocliente");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			switch($row['idgrupo'])
			{
				case "1":
			$vgrupo1=$row['descuento'];
			break;
			case "2":
			$vgrupo2=$row['descuento'];
			break;
			case "3":
			$vgrupo3=$row['descuento'];
			break;
			}
		}
								?>
				<form method="post" action="clientgroup.php">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descuento<small> (expresado en porcentaje)</small></th>
										
                                    </tr>
                                </thead>
                                <tbody>
								<tr><td>Consumidor Final</td><td><input type="text" class="form-control" name="grupo1" value="<?php echo $vgrupo1;?>" required></td></tr>
								<tr><td>Mecanicos</td><td><input type="text" class="form-control" name="grupo2" value="<?php echo $vgrupo2;?>" required></td></tr>
								<tr><td>Repuesteros</td><td><input type="text" class="form-control" name="grupo3" value="<?php echo $vgrupo3;?>" required></td></tr>
								</tbody>
								</table>
								<br>
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
	