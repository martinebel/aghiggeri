<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editar Cliente</h1>
                </div>
            </div>

             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="clientes.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="action" value="edit">
				  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
				 <?php
 $stmt = $dbh->prepare("SELECT * from clientes where idcliente=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$id=$row['idcliente'];
			$idsistema=$row['idsistema'];
			$razonsocial=$row['razonsocial'];
			$cuit=$row['cuit'];
			$direccion=$row['direccion'];
			$localidad=$row['localidad'];
			$provincia=$row['provincia'];
			$telefono=$row['telefono'];
			$email=$row['email'];
			$tipo=$row['tipo'];
		}
 ?>


<div class="col-md-12">
 <div class="form-group">
  <label for="usr">Razon Social:</label>
  <input type="text" class="form-control" id="usr" name="razonsocial" value="<?php echo $razonsocial;?>" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="marca">CUIT / CUIL / DNI:</label>
  <input type="text" class="form-control" id="marca" name="cuit" value="<?php echo $cuit;?>" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="telefono">Telefono:</label>
   <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono;?>" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
 <label for="idsistema">Codigo Sistema:</label>
 <input type="text" class="form-control" id="idsistema" name="idsistema" value="<?php echo $idsistema;?>">
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="direccion">Direccion:</label>
  <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion;?>" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="localidad">Localidad:</label>
  <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo $localidad;?>" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="provincia">Provincia:</label>
  <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo $provincia;?>" required>
</div>
</div>

<div class="col-md-6">
 <div class="form-group">
  <label for="email">Email:</label>
  <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" required>
</div>
</div>

<div class="col-md-6">
 <div class="form-group">
  <label for="tipo">Tipo:</label>
  <select class="form-control" id="tipo" name="tipo" required>
    <option value="0" <?php if($tipo=="0"){echo " selected ";}?>>Ninguno</option>
  <option value="1" <?php if($tipo=="1"){echo " selected ";}?>>Consumidor Final</option>
  <option value="2" <?php if($tipo=="2"){echo " selected ";}?>>Mecanico</option>
  <option value="3" <?php if($tipo=="3"){echo " selected ";}?>>Repuestero</option>
  </select>
</div>
</div>

<input type="submit" value="Guardar" class="btn btn-success">
<a href="clientes.php?action=clave&id=<?php echo $_REQUEST['id'];?>" class="btn btn-warning">Blanquear Clave</a>
<a href="clientes.php?action=del&id=<?php echo $_REQUEST['id'];?>" class="btn btn-danger pull-right">ELIMINAR</a>
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
	<script>
	function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#img").change(function(){
    readURL(this);
});
	</script>
