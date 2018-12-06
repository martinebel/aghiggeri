<?php include 'header.php';?>
<link href="dist/css/jquery-ui.css" rel="stylesheet">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Banner de Marcas</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				 <div class="panel panel-default">
  <div class="panel-body">
   <div class="col-md-6">
								<form method="post" action="marcas.php" enctype="multipart/form-data">
								<p><strong>Agregar Imagen de Marca</strong></p>
								<small>Tamaño Recomendado: 100px X 50px - Formato  PNG con fondo transparente</small>
								 <img id="preview" style="max-width:100%;" >
   <input type="file" name="pic" id="img" accept="image/*">
   <input type="hidden" name="action" value="addbanner">
   <input type="submit" class="btn btn-success" value="Guardar">
								</form>
								</div>
  </div>
</div>


	<p><strong>Marcas mostradas en la pagina de Inicio</strong></p>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla">
								<?php
								$tipo="odd";
								if ($handle = opendir('../img/m')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

			echo ' <tr  class="'.$tipo.'">
                                        <td>'.$entry.'</td>
                                        <td><img style="max-width:50px;" src="../img/m/'.$entry.'"></td>
                                        <td class="center"><a href="marcas.php?action=delete&archivo='.$entry.'"  class="btn btn-warning">Quitar</a></td>
                                    </tr>';
									if($tipo=="odd"){$tipo="even";}else{$tipo="odd";}
									
        }
    }

    closedir($handle);
}
			
		
								?>
								
								</tbody>
								</table>
								
								<hr>
								
								
				</div>
				</div>
           
            </div>
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
	<script src="dist/js/jquery-ui.min.js"></script>
	<script>
	var numero=<?php echo $numero;?>;
	function quitar(numero)
	{
		$("#fila"+numero).remove();
	}
	
	$(function() {
    function log( msg,codigo ) {
  //traer datos del cliente
  $("#buscar").val(msg);
      $.ajax({
        type: "POST",
        url: "ajax_search.php?codigo="+codigo,
        processData: false, 
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	
 var obj = JSON.parse( datae );
 $("#tabla").append('<tr id="fila'+numero+'"><td>'+obj[0].codigo+'</td> <td><input type="hidden" name="producto[]" value="'+obj[0].id+'"><img style="max-width:50px;" src="../img/p/'+obj[0].imagen+'">&nbsp;'+obj[0].nombre+'</td> <td class="center"><a href="#" onclick="quitar('+numero+');"  class="btn btn-warning">Quitar</a></td>');
    numero++;
	})
    .fail(function(jqXHR, textStatus, errorThrown){     
	    
    });
    }
 
    $( "#buscar" ).autocomplete({
      source: "ajax_search.php",
      minLength: 2,
      select: function( event, ui ) {
		 
        log(ui.item.label,ui.item.id);
      },   
    response: function(event, ui) {

    }
    })
     
  });
	</script>
	
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