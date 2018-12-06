<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Vendedor</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <form action="vendedores.php" method="post">
				 <input type="hidden" name="action" value="nuevo">
				 <div class="form-group">
  <label for="usr">Nombre:</label>
  <input type="text" class="form-control" id="usr" name="nombre" placeholder= "Ej: Martin Ebel" required>
</div>

				 <div class="form-group">
  <label for="pass">Usuario:</label>
  <input type="text" class="form-control" id="usuario" name="usuario"placeholder= "Ej: mebel" required>
</div>

 <div class="form-group">
  <label for="tipo">Contraseña:</label>
   <input type="password" class="form-control" id="pass" name="pass"  required>
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
