
  <?php
  include 'header.php';
  ?>




  <div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
 <div class="col-md-12" style="padding: 0px;">
    <div class="row">
	<!------------------------>
	<div class="hidden-xs col-md-3">

    <div class="well" style="padding: 8px 0;">

 <div style=" overflow-x: hidden;">
     <ul class="nav nav-list">
<li><label class="tree-toggler nav-header">Filtros</label>
<ul class="nav nav-list tree">
<form method="get" action="?" style="padding: 3px 15px;">
<li>
<select id="marcaauto" class="form-control" name="marcaauto">
<?php
$filtro1="";$filtro2="";$filtro3="";
if(isset($_REQUEST['marcaauto']))
{

if($_REQUEST['marcaauto']!=$_SESSION['marcaauto'])
{
  $_SESSION['marcaauto']="0";
  $_SESSION['modeloauto']="0";
}
$_SESSION['marcaauto']=$_REQUEST['marcaauto'];
}

  if(isset($_REQUEST['modeloauto']) )
  {
    $_SESSION['modeloauto']=$_REQUEST['modeloauto'];
  }

  if(isset($_REQUEST['marca']) )
  {
    $_SESSION['marca']=$_REQUEST['marca'];
  }

/********************/
if(isset($_SESSION['marcaauto']) && $_SESSION['marcaauto']!="0")
{
$filtro1=" and marcaauto='".$_SESSION['marcaauto']."' ";
}
else {
  $_SESSION['marcaauto']="0";
  $_SESSION['modeloauto']="0";

}

  if(isset($_SESSION['modeloauto']) && $_SESSION['modeloauto']!="0")
  {
    $filtro2=" and modeloauto='".$_SESSION['modeloauto']."' ";
  }

  if(isset($_SESSION['marca']) && $_SESSION['marca']!="0")
  {
    $filtro3=" and marca='".$_SESSION['marca']."' ";
  }

if(isset($_SESSION['marcaauto']))
{
echo '<option value="0">Todas las Marcas de Vehiculo</option>';
}
else{
 echo '<option value="0" selected>Todas las Marcas de Vehiculo</option>';
}


$stmt = $dbh->prepare("SELECT productos.marcaauto from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto  group by marcaauto");
$stmt->execute();
$result = $stmt->fetchAll();
foreach($result as $row)
{
if(isset($_SESSION['marcaauto']))
{
if($_SESSION['marcaauto']==$row['marcaauto'])
{
echo '<option value="'.$row['marcaauto'].'" selected>'.$row['marcaauto'].'</option>';
}
else
{
echo '<option value="'.$row['marcaauto'].'">'.$row['marcaauto'].'</option>';
}
}
else
{
echo '<option value="'.$row['marcaauto'].'">'.$row['marcaauto'].'</option>';
}
}
echo '</select></li>';
//modeloauto
if(isset($_SESSION['marcaauto']) && $_SESSION['marcaauto']!="0")
{
echo ' <li>
<select id="modeloauto" class="form-control" name="modeloauto">';
if(isset($_SESSION['modeloauto']))
{
echo '<option value="0">Todos los Modelos</option>';
}
else{
 echo '<option value="0" selected>Todos los Modelos</option>';
}
$stmt = $dbh->prepare("SELECT productos.modeloauto from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto where marcaauto='".$_SESSION['marcaauto']."' group by modeloauto");
$stmt->execute();
$result = $stmt->fetchAll();
foreach($result as $row)
{
if(isset($_SESSION['modeloauto']))
{
if($_SESSION['modeloauto']==$row['modeloauto'])
{
echo '<option value="'.$row['modeloauto'].'" selected>'.$row['modeloauto'].'</option>';
}
else
{
echo '<option value="'.$row['modeloauto'].'">'.$row['modeloauto'].'</option>';
}
}
else
{
echo '<option value="'.$row['modeloauto'].'">'.$row['modeloauto'].'</option>';
}
}
echo '</select></li>';
}


//marca repuesto
echo '<li>
<select id="marca" class="form-control" name="marca">';

if(isset($_SESSION['marca']))
{
echo '<option value="0">Todas las Marcas</option>';
}
else{
 echo '<option value="0" selected>Todas las Marcas</option>';
}


$stmt = $dbh->prepare("SELECT productos.marca from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto  group by marca");
$stmt->execute();
$result = $stmt->fetchAll();
foreach($result as $row)
{
if(isset($_SESSION['marca']))
{
if($_SESSION['marca']==$row['marca'])
{
echo '<option value="'.$row['marca'].'" selected>'.$row['marca'].'</option>';
}
else
{
echo '<option value="'.$row['marca'].'">'.$row['marca'].'</option>';
}
}
else
{
echo '<option value="'.$row['marca'].'">'.$row['marca'].'</option>';
}
}
echo '</select></li>';
?>
</form>
</ul>
</li>
</ul>
</div>
</div>
	 <div id="wrapperMenu">
	       <div class="panel-group" id="menu-dashboard">
  <div class="panel panel-default">
  <?php
				  //traer categorias del mismo nivel que esta


		$stmt = $dbh->prepare("select * from categorias where padre=0");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
  $stmt2 = $dbh->prepare("select categorias.* from categoriaproductos inner join categorias on categorias.id=categoriaproductos.idcategoria inner join productos on productos.id=categoriaproductos.idproducto where padre=".$row['id'].$filtro1.$filtro2.$filtro3." group by categorias.id,categorias.nombre,categorias.padre");
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
    if($stmt2->rowCount()>0)
    {
      echo '<div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#menu-dashboard" href="#collapse'.$row['id'].'">
         <span class="icon-link2"></span>
                          '.$row['nombre'].'<span class="caret"></span></a>
        </h4>
      </div>
    <div id="collapse'.$row['id'].'" class="panel-collapse collapse"> <ul class="list-group">
                         ';
		foreach($result2 as $row2)
		{
			echo ' <li><a href="productlist.php?id='.$row2['id'].'">'.strtoupper($row2['nombre']).'</a></li>';

		}
                    echo '</ul>
  </div>';
}
		}
		?>
		</div>
	 </div>
	</div>
  </div>

<!------------------------>


 <div class="col-md-9" style="padding: 0px;">
<?php
if( !isset($_SESSION['cid']) ){
   echo '<div class="col-md-12">
     <div class="alert alert-info" role="alert"><i class="fa fa-info-circle"></i>  Recuerde <strong><a href="login.php">iniciar su sesion</a></strong> o <strong><a href="register.php">registrarse si no tiene una cuenta.</a></strong> Puede llevar el control de sus pedidos y acceder a importantes descuentos.</div>
   </div>';
 }
   ?>
	<div class="col-md-12 hidden-xs" style="text-align:center">
	<?php
	if ($handle = opendir('./img/m')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo '<img class="logomarca" src="img/m/'.$entry.'">';
        }
    }

    closedir($handle);
}
	?>
	</div>

	<?php
	$contador=0;
	$stmt = $dbh->prepare("SELECT productos.* from paginicio inner join productos on productos.id=paginicio.idprod");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			echo ' <div class="col-md-4">
            <div class="product-item">
              <div class="pi-img-wrapper">';


                if(!empty($row["imagen"]))
			{
				$path_parts = pathinfo('./img/p/'.$row['imagen']);
				$file=$path_parts['filename'];
				//probar si existe con extension mayuscula
				$ext = strtoupper($path_parts['extension']);
				if(file_exists('./img/p/'.$file.".".$ext))
				{
					echo '<img src="./img/p/'.$file.".".$ext.'" onerror="this.src=\'default.jpeg\';"  class="img-responsive" />';
				}
				elseif(file_exists('./img/p/'.$file.".".strtolower($ext)))
				{
					echo '<img src="./img/p/'.$file.".".strtolower($ext).'" onerror="this.src=\'default.jpeg\';" class="img-responsive" />';
				}
				else
			{
				echo '<img src="default.jpeg"  class="img-responsive" />';
			}
			}
			else
			{
				echo '<img src="default.jpeg"  class="img-responsive" />';
			}
                echo '<div>
                  <a href="detalle.php?id='.$row['id'].'" class="btn">Ver Detalles</a>
                </div>
              </div>
              <h3><a href="detalle.php?id='.$row['id'].'">'.$row['descripcion'].'</a><br> <small style=""><strong>'.$row['marca'].' '.$row['codigo'].'</strong> <span class="pull-right"><strong>Stock:</strong> '.($row['stock']>=2?'DISPONIBLE':'CONSULTAR').'</span></small><br>';
    //          if((isset($_SESSION["cid"])) && ($_SESSION["tipousuario"]!="0")){
		//	  if($funciones->showPrices()){
			  if($row["cantoferta"]>0)
						{
							echo '<br><small>GANE '.$row["descuento"]."% EXTRA!! Comprando ".$row["cantoferta"]." unidades</small><br>";
						}
			  echo '</h3>';

              if($funciones->esOferta($row['id']))
					{
						echo '<div class="sticker sticker-offer"></div>';
						echo '<div class="pi-price"><small class="precioviejo">$'.number_format($row['precio'],2,',','.').'</small> $'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small><br><small><strong>Oferta Valida hasta el '.$funciones->getFinOferta($row['id']).'</strong></small></div>';
					}
					else
					{
						echo '<div class="pi-price">$'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small><br><small>&nbsp;</small></div>';
					}
               echo '<a href="#" onclick="addCart('.$row['id'].');" class="btn add2cart">Comprar</a>';
        //   }
			 // }
			   if($funciones->esNuevo($row['id']))
			   {
				   echo '<div class="sticker sticker-new"></div>';
			   }

           echo ' </div>
        </div>';
			$contador++;
			if($contador==4)

				{
					if (file_exists("img/banner.jpg")) {
					echo '<div class="col-md-12">
		<img src="img/banner.jpg" style="width:100%">
		</div>';
					}
				}
		}
		if($contador<4)
		{
			if (file_exists("img/banner.jpg")) {
					echo '<div class="col-md-12">
		<img src="img/banner.jpg" style="width:100%">
		</div>';
					}
		}
	?>



	 </div>

    </div>
	</div>
</div>





  <?php
  include 'footer.php';
  ?>
  <script>
  jQuery(function() {
    jQuery('#marcaauto').change(function() {

  $( "#modeloauto" ).remove();
        this.form.submit();
    });

    jQuery('#modeloauto').change(function() {
        this.form.submit();
    });

        jQuery('#marca').change(function() {
        this.form.submit();
    });
  });
  </script>
