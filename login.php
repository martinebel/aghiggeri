
  <?php
  include 'header.php';
  ?>
    
    
    
    
  <div class="container">
   <div class="row">
      <div class="col-md-4 col-md-offset-4" style="margin-top:40px;">
                <div class="login-panel panel panel-default">
                   
                    <div class="panel-body">
							<?php
if(isset($_REQUEST['e']))
{
	echo '<div class="alert alert-danger" role="alert">El usuario no se encuentra o los datos son incorrectos.</div>';
}
?>
      
                        <form action="validation.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="CUIT" name="cuit" id="cuit" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" type="password" value="" required>
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Iniciar Sesion">
                                <br>
                                 
                                    <p><a href="forgot.php">Olvidó su clave? Haga Clic Aqui</a></p>
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>  
    
    
    
    
    
  <?php
  include 'footer.php';
  ?>
<script>
  $(document).on("input", "#cuit", function() {
    this.value = this.value.replace(/\D/g,'');
});
</script>