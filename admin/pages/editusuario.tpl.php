<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Modificar Usuario</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="usuarios.php" method="post">
				   <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
				   <?php
 $stmt = $dbh->prepare("SELECT * from usuarios where codigo=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$nombre=$row['usuario'];
			$pass=$row['pass'];
			$tipo=$row['tipo'];
		}
 ?>
				 <input type="hidden" name="action" value="edit">
				 <div class="form-group">
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre" value="<?php echo $nombre;?>" required>
</div>

				 <div class="form-group">
  <label for="pass">Nombre:</label>
  <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $pass;?>" required>
</div>

 <div class="form-group">
  <label for="tipo">Tipo:</label>
  <select class="form-control" id="tipo" name="tipo">
  <option <?php if($tipo=="1"){echo "selected";}?> value="1">Administrador</option>
  <option <?php if($tipo=="2"){echo "selected";}?> value="2">Vendedor</option>
  </select>
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