<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Importar Excel: Clientes</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <div class="alert alert-danger">
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
  <strong>Atencion!</strong> Esta acción modifica los clientes que tengan asociado un ID Interno. Si desea cargar nuevos clientes, deje vacía la columa de ID interno en su Excel para aquellos clientes nuevos. Los nuevos clientes se cargarán con la contraseña "123".<br>Tamaño maximo de archivo: <?php echo $qty;?>
</div>
 <div class="alert alert-info">
 <div class="row">
 <h4><strong><i class="fa fa-info-circle fa-fw"></i> RECORDAR</strong></h4>
 <div class="col-md-6">
<p><strong>Tipos de Cliente</strong></p>
 <p>1 - Consumidor Final</p>
 <p>2 - Mecanico</p>
 <p>3 - Repuestero</p>
 </div>
 <div class="col-md-6">
 <p><strong>Tipos de IVA</strong></p>
 <p>1 - Consumidor Final</p>
<p>2 - Responsable Inscripto</p>
<p>4 - Monotributo</p>
<p>5 - Exento</p>
 </div>
 </div>
 </div>
				 <form name="importa" method="post" action="excelclientes.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Col. de ID Interno</p>
<input type="text" name="col_codigo" class="form-control" value="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de ID Sistema</p>
<input type="text" name="col_idsistema" class="form-control" value="B" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Razon Social</p>
<input type="text" name="col_razonsocial" class="form-control" value="C" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de CUIT</p>
<input type="text" name="col_cuit" class="form-control" value="D" required style="text-transform: uppercase">
</div>
</div>

<div class="row">

<div class="col-md-3">
<p>Col. de Telefono</p>
<input type="text" name="col_telefono" class="form-control" value="E" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Direccion</p>
<input type="text" name="col_direccion" class="form-control" value="F" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Localidad</p>
<input type="text" name="col_localidad" class="form-control" value="G" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Provincia</p>
<input type="text" name="col_provincia" class="form-control" value="H" required style="text-transform: uppercase">
</div>
</div>

<div class="row">

<div class="col-md-3">
<p>Col. de Email</p>
<input type="text" name="col_email" class="form-control" value="I" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Tipo Cliente</p>
<input type="text" name="col_tipo" class="form-control" value="J" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Tipo IVA</p>
<input type="text" name="col_responsable" class="form-control" value="K" required style="text-transform: uppercase">
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
		