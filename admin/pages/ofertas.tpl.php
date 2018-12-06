<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Importar Excel: Ofertas</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				  <div class="alert alert-warning">
  <strong>Atencion!</strong> Esta acción no modifica las ofertas ya existentes, sino que elimina todos los registros y carga toda la información contenida en el Excel. El formato de fechas es <strong>aaaa-mm-dd</strong>
</div>
				 <form name="importa" method="post" action="ofertas.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Col. de Codigo</p>
<input type="text" name="col_codigo" class="form-control" value="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Fecha Inicio</p>
<input type="text" name="col_finicio" class="form-control" value="B" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Fecha Fin</p>
<input type="text" name="col_ffin" class="form-control" value="C" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Descuento</p>
<input type="text" name="col_descuento" class="form-control" value="D" required style="text-transform: uppercase">
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
                   
				</div>
				</div>
           
            </div>
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
		