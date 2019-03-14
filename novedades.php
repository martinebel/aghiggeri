  <?php
  include 'header.php';
  ?>


   <?php
    $filtro="";
   $fMarca="%";
   if((isset($_REQUEST['id'])) && ($_REQUEST['id']!='%'))
   {
   	$filtro=" and marca='".$_REQUEST['id']."'";
   	$fMarca=$_REQUEST['id'];
   }
   //calcular paginacion
   $totalpaginas=0;
   $productosporpagina=12;
   $paginaactual=1;
    if(isset($_REQUEST['p'])){$paginaactual=$_REQUEST['p'];}
	$stmt = $dbh->prepare("SELECT * FROM productos WHERE `fechaalta` > timestampadd(day, -45, now()) ".$filtro);
        $stmt->execute();
		$result = $stmt->fetchAll();
		$totalitems=$stmt->rowCount();
		if($totalitems<6)
		{
			$stmt = $dbh->prepare("SELECT * FROM productos order by fechaalta desc limit 0,6");
        $stmt->execute();
		$result = $stmt->fetchAll();
		}
		$totalitems=$stmt->rowCount();
		$totalpaginas=ceil($totalitems/$productosporpagina);


	?>
<div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
	 <div class="col-md-12" style="padding: 0px;">
	<div class="row">

	<!------------------------>
	<div class="hidden-xs col-md-3">
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
		echo '<div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#menu-dashboard" href="#collapse'.$row['id'].'">
       <span class="icon-link2"></span>
                        '.$row['nombre'].'<span class="caret"></span></a>
      </h4>
    </div>
	<div id="collapse'.$row['id'].'" class="panel-collapse collapse"> <ul class="list-group">
                       ';
                             $stmt2 = $dbh->prepare("select * from categorias where padre=".$row['id']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll();
		foreach($result2 as $row2)
		{
			echo ' <li><a href="productlist.php?id='.$row2['id'].'">'.strtoupper($row2['nombre']).'</a></li>';

		}
                    echo '</ul>
  </div>';
		}
		?>
		</div>
	 </div>
	</div>
  </div>

<!------------------------>
<div class="col-md-9" style="padding: 0px;">



	<?php


	$stmt = $dbh->prepare("SELECT * FROM productos WHERE `fechaalta` > timestampadd(day, -45, now())  ".$filtro." limit ".$productosporpagina." OFFSET ".(($paginaactual-1)*$productosporpagina));
        $stmt->execute();
		$result = $stmt->fetchAll();
		$totalitems=$stmt->rowCount();
		if($totalitems<6 && $paginaactual==1)
		{
			$stmt = $dbh->prepare("SELECT * FROM productos order by fechaalta desc limit 0,6");
        $stmt->execute();
		$result = $stmt->fetchAll();
		}
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
              <h3><a href="detalle.php?id='.$row['id'].'">'.$row['descripcion'].'</a><br> <small style=""><strong>'.$row['marca'].' '.$row['codigo'].'</strong> <span class="pull-right"><strong>Stock:</strong> '.($row['stock']>=2?'DISPONIBLE':'CONSULTAR').'</span></small><br></h3>';
      //           if((isset($_SESSION["cid"])) && ($_SESSION["tipousuario"]!="0")){
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
      //     }
			 // }
			   if($funciones->esNuevo($row['id']))
			   {
				   echo '<div class="sticker sticker-new"></div>';
			   }

           echo ' </div>
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
      <a  href="novedades.php?p='.($paginaactual-1).'&id='.$fMarca.'" aria-label="Previous">
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
			echo ' <li><a href="novedades.php?p='.($i+1).'&id='.$fMarca.'">'.($i+1).'</a></li>';
		}
	}

	//boton SIGUIENTE
	if($paginaactual<$totalpaginas)
	{
		echo '<li>
      <a  href="novedades.php?p='.($paginaactual+1).'&id='.$fMarca.'"  aria-label="Next">
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
	</div>


      <?php
  include 'footer.php';
  ?>
