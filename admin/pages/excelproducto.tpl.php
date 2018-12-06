<?php include 'header.php';?>
<style>
.col-md-3
{
    padding:10px;
}
</style>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Importar Excel: Productos</h1>
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
  <strong>Atencion!</strong> Esta acción no modifica los productos ya existentes, sino que INSERTA NUEVOS REGISTROS con la información contenida en el Excel. Prestar atención al contenido del Excel, ya que si por alguna razón hay datos duplicados esto no será controlado, dando como resultado productos duplicados o errores de inserción.<br>Tamaño maximo de archivo: <?php echo $qty;?>
</div>
				 <form name="importa" method="post" action="excelproducto.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Col. de Codigo</p>
<input type="text" name="col_codigo" class="form-control" value="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Nombre</p>
<input type="text" name="col_nombre" class="form-control" value="B" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Marca</p>
<input type="text" name="col_marca" class="form-control" value="C" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Precio</p>
<input type="text" name="col_precio" class="form-control" value="D" required style="text-transform: uppercase">
</div>
</div>

<div class="row">

<div class="col-md-3">
<p>Col. de Descripcion</p>
<input type="text" name="col_desc" class="form-control" value="E" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Marca de Auto</p>
<input type="text" name="col_marcaauto" class="form-control" value="F" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Modelo de Auto</p>
<input type="text" name="col_modeloauto" class="form-control" value="G" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Col. de Categoria</p>
<input type="text" name="col_categoria" class="form-control" value="H" required style="text-transform: uppercase">
</div>
</div>

<div class="row">

<div class="col-md-3 bg-danger" style="border:1px solid;">  
  <p>Col. de Imagen</p>
  <input type="text" name="col_imagen" class="form-control  form-control-danger" value="I" required style="text-transform: uppercase" id="inputDanger1">
</div>

<div class="col-md-3">
    <p>Col. Desc. Larga</p>
  <input type="text" name="col_desclarga" class="form-control" value="J" required style="text-transform: uppercase">
</div>

<div class="col-md-3 bg-danger" style="border:1px solid;">
  <p>Col. de Fecha</p>
  <input type="text" name="col_fecha" class="form-control  form-control-danger" value="K" required style="text-transform: uppercase" id="inputDanger2">
</div>


<div class="col-md-3 bg-danger" style="border:1px solid;">
  <p>Col. de Cant. Descuento</p>
  <input type="text" name="col_cantoferta" class="form-control  form-control-danger" value="L" required style="text-transform: uppercase" id="inputDanger3">
</div>

<div class="col-md-3 bg-danger" style="border:1px solid;">
  <p>Col. de Cant. Descuento</p>
  <input type="text" name="col_descuento" class="form-control  form-control-danger" value="M" required style="text-transform: uppercase" id="inputDanger4">
</div>



<div class="col-md-3 bg-danger" style="border:1px solid;">
  <p>Col. de Stock</p>
  <input type="text" name="col_stock" class="form-control  form-control-danger" value="N" required style="text-transform: uppercase" id="inputDanger5">
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
		