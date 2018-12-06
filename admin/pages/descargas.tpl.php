<?php include 'header.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Descarga de Datos</h1>
                </div>
            </div>
           
             <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				  <div class="alert alert-info">
  <strong>Info</strong> Desde esta página se pueden descargar listados en formato Excel para las tablas mas importantes del sistema. Recuerde que puede usar estos listados como modelos para cargar datos desde un archivo excel. Haga click sobre la tabla que desea descargar.
</div>
<div class="col-md-3">
				 <form action="descargas.php" method="post">
	<input type="hidden" name="action" value="productos">			   
<input type="submit" value="Productos" class="btn btn-success">
				 </form>
</div>
<div class="col-md-3">				 
				 <form action="descargas.php" method="post">
	<input type="hidden" name="action" value="clientes">			   
<input type="submit" value="Clientes" class="btn btn-success">
				 </form>
   </div>    

<div class="col-md-3">				 
				 <form action="descargas.php" method="post">
	<input type="hidden" name="action" value="categorias">			   
<input type="submit" value="Categorias" class="btn btn-success">
				 </form>
   </div>   

   <div class="col-md-3">        
         <form action="descargas.php" method="post">
  <input type="hidden" name="action" value="imagenes">         
<input type="submit" value="Imagenes Faltantes" class="btn btn-success">
         </form>
   </div>   
   

  

<!--<div class="col-md-3">				 
				 <form action="descargas.php" method="post">
	<input type="hidden" name="action" value="ofertas">			   
<input type="submit" value="Ofertas" class="btn btn-success">
				 </form>
   </div>   -->   
				</div>
				</div>
           
            </div>
          <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Backup de Base de Datos</h1>
					 
                </div>
				 <div class="row">
                <div class="col-lg-12">
				 <div class="panel-body">
				  <div class="alert alert-info">
  <strong>Info</strong> Esta accion produce un archivo en formato SQL, conteniendo el script necesario para la creacion de la estructura de la base de datos y todos sus registros. Puede demorar.
</div>
<a href="backup.php" target="_blank" class="btn btn-primary btn-lg"> <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Realizar backup</a>
            </div> 
			 </div>
			  </div>
			  
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<?php include 'footer.php';?>
