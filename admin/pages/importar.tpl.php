<?php 
$pagetitle="Importar desde Excel";
include 'header.php';
require 'acl.php';

$idusuario=$_SESSION['idusuario'];

 /*$classA = new Acl();
$classA->isAllowed('restaurantes.php',$idusuario);*/
?>
<link href="vendor/css/jquery.bootgrid.css" rel="stylesheet">
	<!-- Content -->
	<div class="container">

		<!-- Breadcrumb -->
		<ol class="breadcrumb">
			<li><a href="dashboard.php">Wonerz</a></li>
			<li>Catalogo</li>
			<li class="active">Importar desde Excel</li>
		</ol>
		<!-- // END Breadcrumb -->

		<div class="card">
			<div class="card-block">
			<div class="row">
			 <div id="notify"></div>
			<div class="col-md-12">
				<fieldset>
				<form name="importa" method="post" action="importar.php" enctype="multipart/form-data" >
<div class="row">
<div class="col-md-3">
<p>Columna de Codigo del Producto</p>
<input type="text" name="col_codigo" class="form-control" placeholder="A" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Columna de Nombre</p>
<input type="text" name="col_name" class="form-control" placeholder="B" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Columna de Modelo</p>
<input type="text" name="col_model" class="form-control" placeholder="C" required style="text-transform: uppercase">
</div>
</div>

<div class="row">
<div class="col-md-3">
<p>Columna de ID del Fabricante</p>
<input type="text" name="col_marca" class="form-control" placeholder="D" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Columna de ID de Categoria</p>
<input type="text" name="col_categoria" class="form-control" placeholder="E" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Columna de Descripcion</p>
<input type="text" name="col_desc" class="form-control" placeholder="F" required style="text-transform: uppercase">
</div>
</div>

<div class="row">
<div class="col-md-3">
<p>Columna de Precio de Contado</p>
<input type="text" name="col_price" class="form-control" placeholder="G" required style="text-transform: uppercase">
</div>
<div class="col-md-3">
<p>Columna de Precio para TodoPago</p>
<input type="text" name="col_price_tp" class="form-control" placeholder="H" required style="text-transform: uppercase">
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

					


				</fieldset>
			</div>
			</div>
</div>
		</div>


	</div>
	<!-- // END Content -->
<?php 

include 'footer.php';
?>
	
<script type="text/javascript">
  $("#notify").html('<?php echo $mensaje;?>');
</script>
