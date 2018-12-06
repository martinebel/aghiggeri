<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editar Categoria</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="categorias.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="action" value="edit">
				  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
				 <div class="form-group">
				  <?php
 $stmt = $dbh->prepare("SELECT * from categorias where id=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$id=$row['id'];
			$nombre=$row['nombre'];
			$padre=$row['padre'];
		}
 ?>
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre" value="<?php echo $nombre;?>" required>
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
			if($padre==$row['id'])
			{echo '<option selected value="'.$row['id'].'">'.$row['nombre'].'</option>';}
		else
		{echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>'; }
		}
 ?>
 </select>
 				 <div class="form-group">
  <label for="img">Imagen (debe ser JPG):</label>
  <br>
  <img id="preview" style="max-width:100px;" src="../img/c/<?php echo $id;?>.jpg">
   <input type="file" name="pic" id="img" accept="image/*">
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