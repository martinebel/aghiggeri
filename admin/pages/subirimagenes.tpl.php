<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cargar Imagenes</h1>
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
  <strong>Atencion!</strong> Este proceso puede tardar mucho! No cierre la pagina hasta recibir el aviso de que se han terminado de cargar los datos.<br>Tamaño maximo de archivo: <?php echo $qty;?>
</div>
				 <form name="importa" method="post" action="subirimagenes.php" enctype="multipart/form-data" >

<div class="row">
<div class="col-md-6 col-md-offset-3">
<p>Archivo ZIP</p>
<input type="file" required name="excel" accept=".zip" />
 </br>
          <input type="submit" id="enviar" name="enviar" class="btn btn-success" value="Cargar">
</div>
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
		