  <?php
  include 'header.php';
  ?>


   <?php
   //calcular paginacion
   $totalpaginas=0;
   $productosporpagina=12;
   $paginaactual=1;

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


    if(isset($_REQUEST['p'])){$paginaactual=$_REQUEST['p'];}
	$stmt = $dbh->prepare("SELECT productos.* from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto where idcategoria=".$_REQUEST['id'].$filtro1.$filtro2.$filtro3." order by marcaauto,modeloauto");
        $stmt->execute();
		$result = $stmt->fetchAll();
		$totalpaginas=$stmt->rowCount();
		$totalpaginas=ceil($totalpaginas/$productosporpagina);

	$stmt = $dbh->prepare("select * from categorias where id=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$padre=$row['padre'];
			$nombre=$row['nombre'];
		}
		echo '<ol class="breadcrumb" style="margin-bottom:0px;">
  <li><a href="index.php">INICIO</a></li>';
			$stmt = $dbh->prepare("select * from categorias where id=".$padre);
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			if($row['padre']!="0"){
			echo ' <li><a href="category.php?id='.$padre.'">'.strtoupper($row['nombre']).'</a></li>';
			}

		}
		echo '<li class="active">'.strtoupper($nombre).'</li>';
		echo '</ol>';
	?>
<div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
	<div class="row">

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
<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
</form>
</ul>
</li>
</ul>
</div>
</div>

	 <div id="wrapperMenu">
	        <ul id="menu-dashboard"class="nav nav-pills nav-stacked">
                    <?php
				  //traer categorias del mismo nivel que esta


		$stmt = $dbh->prepare("select categorias.* from categoriaproductos inner join categorias on categorias.id=categoriaproductos.idcategoria inner join productos on productos.id=categoriaproductos.idproducto where padre=".$padre.$filtro1.$filtro2.$filtro3." group by categorias.id,categorias.nombre,categorias.padre");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{

			 if($row['id']==$_REQUEST['id'])
			{
				echo '<li class="active"><a href="#"><span class="icon-home4"></span> <span class="hidden-xs">'.(strtoupper($row['nombre'])).'</span></a></li>';
			}
			else
			{

			echo '<li><a href="productlist.php?id='.$row['id'].'"><span class="icon-home4"></span> <span class="hidden-xs">'.(strtoupper($row['nombre'])).'</span></a></li>';
			}
		}
		?>
			</ul>
	 </div>

  </div>

	<div class="col-md-9 col-xs-12">
	<legend><?php echo $nombre; ?></legend>

	<?php


	$stmt = $dbh->prepare("SELECT productos.* from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto where idcategoria=".$_REQUEST['id'].$filtro1.$filtro2.$filtro3." order by marcaauto,modeloauto limit ".$productosporpagina." OFFSET ".(($paginaactual-1)*$productosporpagina));
        $stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount()==0) { echo '<p>No se encuentran productos para esta categoria</p>';}
		foreach($result as $row)
		{
			echo '<div class="row product-item" >';
	if($funciones->esOferta($row['id']))
					{
						echo '<div class="sticker sticker-offer"></div>';
					}

				if($funciones->esNuevo($row['id']))
			   {
				   echo '<div class="sticker sticker-new"></div>';
			   }

              echo '<div class="col-md-3 pi-img-wrapper">';

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
			  <div class="col-md-9">
               <h3><a href="detalle.php?id='.$row['id'].'">'.$row['descripcion'].'</a><br> <small style=""><strong>'.$row['marca'].' '.$row['codigo'].'</strong> <span class="pull-right"><strong>Stock:</strong> '.($row['stock']>=2?'DISPONIBLE':'CONSULTAR').'</span></small><br>';
                 if((isset($_SESSION["cid"])) && ($_SESSION["tipousuario"]!="0")){
			  if($funciones->showPrices()){
			  if($row["cantoferta"]>0)
						{
							echo '<br><small>GANE '.$row["descuento"]."% EXTRA!! Comprando ".$row["cantoferta"]." unidades</small><br>";
						}
			  echo '</h3>';
					if($funciones->esOferta($row['id']))
					{

						echo '<div class="pi-price"><small class="precioviejo">$'.number_format($row['precio'],2,',','.').'</small> $'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small><br><small><strong>Oferta Valida hasta el '.$funciones->getFinOferta($row['id']).'</strong></small></div>';
					}
					else
					{
						echo '<div class="pi-price">$'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small></div>';
					}


             echo '<a href="#" onclick="addCart('.$row['id'].');" class="btn add2cart">Comprar</a>';
         }
     }
           echo '</div>
	</div>';
		}

	?>



	<div class="col-md-12 col-xs-12" style="text-align:center">
	<nav aria-label="Page navigation">
  <ul class="pagination">


    <?php
	//boton ATRAS
	if($paginaactual>1)
	{
		echo '<li>
      <a  href="productlist.php?id='.$_REQUEST['id'].'&p='.($paginaactual-1).'" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>';
	}
	//numeritos
	for($i=0;$i<$totalpaginas;$i++)
	{
		if($i==($paginaactual-1))
		{
			echo ' <li class="active"><a href="#">'.($i+1).'</a></li>';
		}
		else
		{
			echo ' <li><a href="productlist.php?id='.$_REQUEST['id'].'&p='.($i+1).'">'.($i+1).'</a></li>';
		}
	}

	//boton SIGUIENTE
	if($paginaactual<$totalpaginas)
	{
		echo '<li>
      <a  href="productlist.php?id='.$_REQUEST['id'].'&p='.($paginaactual+1).'"  aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>';
	}
	?>


  </ul>
</nav>
</div>
	</div>

	</div>
</div>

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
