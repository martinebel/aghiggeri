<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editar Producto</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="productos.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="action" value="edit">
				  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
				 <?php
 $stmt = $dbh->prepare("SELECT * from productos where id=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$id=$row['id'];
			$codigo=$row['codigo'];
			$nombre=$row['nombre'];
			$marca=$row['marca'];
			$precio=$row['precio'];
			$descripcion=$row['descripcion'];
			$marcaauto=$row['marcaauto'];
			$modeloauto=$row['modeloauto'];
			$imagen=$row['imagen'];
			$desclarga=$row['desclarga'];
      $cantoferta=$row['cantoferta'];
      $descuento=$row['descuento'];
      $stock=$row['stock'];
		}
 ?>
 <div class="col-md-4">
  <div class="form-group">
  <label for="codigo">Codigo:</label>
  <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo;?>" placeholder="ejemplo: HT123" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre" value="<?php echo $nombre;?>" placeholder="ejemplo: Filtro de Aire" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="marca">Marca:</label>
  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $marca;?>" placeholder="ejemplo: Bosch" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="precio">Precio:</label>
  <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $precio;?>" placeholder="ejemplo: 150" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="marcaauto">Marca auto:</label>
  <input type="text" class="form-control" id="marcaauto" name="marcaauto" value="<?php echo $marcaauto;?>" placeholder="ejemplo: Renault" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="modeloauto">Modelo auto:</label>
  <input type="text" class="form-control" id="modeloauto" name="modeloauto" value="<?php echo $modeloauto;?>" placeholder="ejemplo: Megane" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="cantoferta">Cant. Descuento:</label>
  <input type="text" class="form-control" id="cantoferta" name="cantoferta" value="<?php echo $cantoferta;?>" placeholder="ejemplo: 10" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="descuento">% Descuento:</label>
  <input type="text" class="form-control" id="descuento" name="descuento" value="<?php echo $descuento;?>" placeholder="ejemplo: 22" required>
</div>
</div>

<div class="col-md-4">
 <div class="form-group">
  <label for="stock">Stock:</label>
  <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $stock;?>" placeholder="ejemplo: 150" required>
</div>
</div>

<div class="col-md-6">
 <div class="form-group">
  <label for="descripcion">Descripcion:</label>
  <textarea rows="4" cols="50" class="form-control" id="descripcion" name="descripcion" placeholder="Describa aqui el producto" required><?php echo $descripcion;?></textarea>
</div>
</div>

<div class="col-md-6">
 <div class="form-group">
  <label for="desclarga">Descripcion Larga:</label>
  <textarea rows="4" cols="50" class="form-control" id="desclarga" name="desclarga" placeholder="Ej: Voltaje: 12V, Color: Negro, Peso: 300grs" required><?php echo $desclarga;?></textarea>
</div>
</div>

<div class="col-md-12">
 <div class="form-group">
  <label for="img">Imagen:</label>
  <br>
  <img id="preview" style="max-width:100px;" src="../img/p/<?php echo $imagen;?>">
   <input type="file" name="pic" id="img" accept="image/*">
</div>
</div>



<div class="clearfix"></div>
<hr>
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