<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Categoria</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="categorias.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="action" value="nuevo">
				 <div class="form-group">
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre" required>
</div>
<div class="form-group">
  <label for="parent">Categoria Padre:</label>
 <select id="parent" name="padre" class="form-control">
 <?php
 $stmt = $dbh->prepare("SELECT * from categorias");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
		}
 ?>
 </select>
 				 <div class="form-group">
  <label for="img">Imagen (debe ser JPG):</label>
  <br>
  <img id="preview" style="max-width:100px;">
   <input type="file" name="pic" id="img" accept="image/*" required>
</div>
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