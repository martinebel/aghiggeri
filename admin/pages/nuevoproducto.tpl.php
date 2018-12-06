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
				 <input type="hidden" name="action" value="nuevo">
				
  <div class="form-group">
  <label for="codigo">Codigo:</label>
  <input type="text" class="form-control" id="codigo" name="codigo"  placeholder="ejemplo: HT123" required>
</div>

 <div class="form-group">
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre"  placeholder="ejemplo: Filtro de Aire" required>
</div>

 <div class="form-group">
  <label for="marca">Marca:</label>
  <input type="text" class="form-control" id="marca" name="marca"  placeholder="ejemplo: Bosch" required>
</div>

 <div class="form-group">
  <label for="precio">Precio:</label>
  <input type="text" class="form-control" id="precio" name="precio"  placeholder="ejemplo: 150" required>
</div>

 <div class="form-group">
  <label for="descripcion">Descripcion:</label>
  <textarea rows="4" cols="50" class="form-control" id="descripcion" name="descripcion" placeholder="Describa aqui el producto" required></textarea>
</div>

 <div class="form-group">
  <label for="marcaauto">Marca auto:</label>
  <input type="text" class="form-control" id="marcaauto" name="marcaauto" placeholder="ejemplo: Renault" required>
</div>

 <div class="form-group">
  <label for="modeloauto">Modelo auto:</label>
  <input type="text" class="form-control" id="modeloauto" name="modeloauto" placeholder="ejemplo: Megane" required>
</div>

 <div class="form-group">
  <label for="img">Imagen (debe ser JPG):</label>
  <br>
  <img id="preview" style="max-width:100px;">
   <input type="file" name="pic" id="img" accept="image/*" required>
</div>

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