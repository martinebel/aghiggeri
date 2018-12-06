<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Importar Excel: Categorias</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				  <div class="alert alert-warning">
				  <?php
				  $value=ini_get('upload_max_filesize');
				  $qty=0;
				   if ( is_numeric( $value ) ) {
        $qty= $value."B";
    } else {
        $value_length = strlen($value);
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k':
                $qty.="KB";
                break;
            case 'm':
                $qty .="MB";
                break;
            case 'g':
                $qty .="GB";
                break;
        }
       
    }
				  ?>
  <strong>Atencion!</strong> Esta acción no modifica las categorias ya existentes, sino que elimina todos los registros y carga toda la información contenida en el Excel. Esto puede afectar a los productos existentes.<br>Tamaño maximo de archivo: <?php echo $qty;?>
</div>
				 <form name="importa" method="post" action="excelcategoria.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Col. de Nombre</p>
<input type="text" name="col_codigo" class="form-control" value="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Padre</p>
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
                   
				</div>
				</div>
           
            </div>
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
		