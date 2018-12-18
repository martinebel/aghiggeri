  <?php
  include 'header.php';
  /*if(isset($_POST['action']))
  {
	  $nombre=$_POST['nombre'];
			$cuit=$_POST['cuit'];
			$email=$_POST['email'];
			$password=md5($_POST['pass']);
			$direccion=$_POST['direccion'];
			$telefono=$_POST['telefono'];
			$localidad=$_POST['localidad'];
			$provincia=$_POST['provincia'];

	  $stmt = $dbh->prepare("insert into clientes values(NULL,'".$nombre."','".$cuit."','".$telefono."','".$direccion."','".$localidad."','".$provincia."','".$email."','".$password."',1,NULL)");
	   $stmt->execute();
	    echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Ha sido registrado correctamente! Puede iniciar su sesion <a href="login.php">haciendo clic aqui</a>
</div>';
  }*/

  ?>
    <div class="container" style=" padding-top: 20px;">

<br>

	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Registrarse</h3>
  </div>
  <div class="panel-body">
     <form id="commentsForm" method="post" style="padding:10px;">
                            <fieldset>

							<input type="hidden" name="action" value="misdatos">
							<div class="row">
							<div class="col-md-12">
                               <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre / Razon Social"  required>
  </div>
  </div>
  <div class="col-md-4">
                                 <div class="form-group">
    <label for="cuit">DNI / CUIT <small>(solo numeros, sin guiones ni puntos)</small></label>
    <input type="text" class="form-control" id="cuit" name="cuit"  placeholder="DNI / CUIT" required>
  </div>
  </div>

   <div class="col-md-4">
                                 <div class="form-group">
    <label for="telefono">Tipo Cliente</label>
    <select class="form-control" id="iva" name="iva" required>
	<option value="1">CONSUMIDOR FINAL</option>
	<option value="2">RESP INSCRIPTO</option>
	<option value="4">MONOTRIBUTO</option>
	<option value="5">EXENTO</option>
	</select>
  </div>
  </div>

   <div class="col-md-4">
                                 <div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="Telefono" required>
  </div>
  </div>
   <div class="col-md-12">
                                 <div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion"  required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="localidad">Localidad</label>
    <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="provincia">Provincia</label>
    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia"  required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email"  placeholder="Email" required>
  </div>
  </div>
   <div class="col-md-6">
                                 <div class="form-group">
    <label for="pass">Contraseña</label>
    <input type="password" class="form-control" id="pass" name="pass"  required>
  </div>
  </div>

                              <div class="col-md-6 col-md-offset-3">
                                <input type="submit" id="botonRegistro" class="btn btn-lg btn-success btn-block" value="Registrarme">
                                <br>
                                <div class="alert alert-info" role="alert"><i class="fa fa-info-circle"></i>  Sus datos personales seran utilizados para identificacion y no seran compartidos con terceros. No se utilizara su telefono, direccion ni casilla de email para el envio de publicidad.</div>
								</div>
                            </fieldset>
                        </form>
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

  $("#commentsForm").submit(function(event){

	   event.preventDefault();
	    $("#botonRegistro").attr('disabled', 'disabled');
	   $("#alerta").remove();
    var form=$("#commentsForm");
    $.ajax({
        type: "POST",
        url: 'registerClass.php',
        data: form.serialize(),
    })
    .success(function(data, textStatus, jqXHR){

      if(data.code=="201"){
        $("#commentsForm").prepend('<div id="alerta" class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ha sido registrado correctamente! Puede iniciar su sesion <a href="login.php">haciendo clic aqui</a></div>');

		$('#commentsForm')[0].reset();
		$("#botonRegistro").removeAttr('disabled');
  }
  else
  {

     $("#commentsForm").prepend('<div id="alerta"  class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ya existe un usuario registrado con este numero de CUIT.</div>');
        $("#botonRegistro").removeAttr('disabled');
  }
    })
    .fail(function(jqXHR, textStatus, errorThrown){
      $("#commentsForm").prepend('<div id="alerta"  class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ya existe un usuario registrado con este numero de CUIT.</div>');
         $("#botonRegistro").removeAttr('disabled');
    });
    event.preventDefault();
	return false;
});
  </script>
