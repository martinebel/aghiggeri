<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Importar Excel: Precios</h1>
                </div>
            </div>

             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">

				 <form name="importa" method="post" action="excel/uploadpreciosexcel.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Col. de Codigo</p>
<input type="text" name="col_codigo" class="form-control" value="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Precio</p>
<input type="text" name="col_nombre" class="form-control" value="B" required style="text-transform: uppercase">
</div>
</div>

<hr>
<div class="row">
<div class="col-md-3">
<p>Fila en la que empiezan los datos</p>
<input type="text" name="fila" class="form-control" placeholder="1" required>
</div>
<div class="col-md-3">
<p>Fila en la que finalizan los datos</p>
<input type="text" name="fila_fin" class="form-control" placeholder="100" required>
</div>
<div class="col-md-3">
<p>Archivo de Excel</p>
<input type="file" required name="excel" />
</div>
</div>

              <div>
          </br>
          <input type="submit" id="enviar" name="enviar" class="btn btn-success" value="Importar">
          </div>
<input type="hidden" value="upload" name="action" />
</form>
<hr>
 <form name="importa" method="post" action="precios.php" >
  <p><strong>Configuracion</strong></p>
  <div class="form-check">
    <?php
    $estado="";
    $stmt = $dbh->prepare("SELECT mostrarprecio from config");
        $stmt->execute();
    $result = $stmt->fetchAll();
    foreach($result as $row)
    {
      if($row["mostrarprecio"]=="1"){$estado=" checked";}
    }
    ?>
  <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="mostrarprecio" <?php echo $estado;?>>
  <label class="form-check-label" for="defaultCheck1">
    Mostrar Precios
  </label>
</div>
    <input type="submit" id="guardar" name="guardar" class="btn btn-success" value="Guardar Configuracion">
<input type="hidden" value="precios" name="action" />
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
