  <?php
  include 'header.php';
/*  $stmt = $dbh->prepare("SELECT * from productos");
     
		$stmt->execute();
		$result = $stmt->fetchAll(); 
  foreach($result as $row)
		{
			$palabras="";
			$palabras=str_replace(' ',',',strtolower($row['nombre']));
			$palabras.=','.strtolower($row['marca']).','.strtolower($row['marcaauto']).','.strtolower($row['modeloauto']);
			 $stmt = $dbh->prepare("update productos set palabrasclave='".$palabras."' where id=".$row['id']);
     
		$stmt->execute();
		}
		die("terminado");*/
  ?>
    
    
   <?php
   $variable="";
   //calcular paginacion
   $totalpaginas=0;
   $productosporpagina=12;
   $paginaactual=1;
    if(isset($_REQUEST['p'])){$paginaactual=$_REQUEST['p'];}
	$keyword=$_REQUEST['keyword'];

	//FIN DICCIONARIO---------------------
	/*$consulta="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$keyword)."') AS relevance FROM productos WHERE MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$keyword)."') or codigo like '%".$keyword."%' or descripcion like '%".$keyword."%' having relevance>1 ORDER BY relevance DESC limit ".$productosporpagina." OFFSET ".(($paginaactual-1)*$productosporpagina);*/
	$consulta="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$keyword)."' IN BOOLEAN MODE) as rel 
FROM (`productos`) 
WHERE MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$keyword)."' IN BOOLEAN MODE) or codigo like '%".$keyword."%' 
ORDER BY `rel` DESC limit ".$productosporpagina." OFFSET ".(($paginaactual-1)*$productosporpagina);

	//echo $consulta;
	$stmt = $dbh->prepare($consulta);
     
		$stmt->execute();
		$result = $stmt->fetchAll(); 
		$totalpaginas=$stmt->rowCount();
		$totalpaginas=ceil($totalpaginas/$productosporpagina);
	
	
		echo '<ol class="breadcrumb" style="margin-bottom:0px;">
  <li><a href="index.php">INICIO</a></li><li class="active">BUSQUEDA</li></ol>';
	?> 
<div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
	<div class="row">
	<legend style="margin-left: 10px;">Resultados de Busqueda: <?php echo $keyword; 
	if($variable!="")
	{
		echo $variable;
	}
	?></legend>
	
	<?php
	
	$consulta="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$keyword)."' IN BOOLEAN MODE) as rel 
FROM (`productos`) 
WHERE MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$keyword)."' IN BOOLEAN MODE) or codigo like '%".$keyword."%' 
ORDER BY `rel` DESC limit ".$productosporpagina." OFFSET ".(($paginaactual-1)*$productosporpagina);
$stmt = $dbh->prepare($consulta);
     
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		if($stmt->rowCount()==0) { echo '<p>No se encuentran productos para esta categoria</p>';}
		foreach($result as $row)
		{
			echo ' <div class="col-md-3">
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
			  if($row["cantoferta"]>0)
						{
							if($funciones->showPrices()){
							echo '<br><small>GANE '.$row["descuento"]."% EXTRA!! Comprando ".$row["cantoferta"]." unidades</small><br>";
						}
						}
			  echo '</h3>';
  if((isset($_SESSION["cid"])) && ($_SESSION["tipousuario"]!="0")){
			 if($funciones->showPrices()){
               if($funciones->esOferta($row['id']))
					{

						echo '<div class="sticker sticker-offer"></div>';
						echo '<div class="pi-price"><small class="precioviejo">$'.number_format($row['precio'],2,',','.').'</small> $'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small><br><small><strong>Oferta Valida hasta el '.$funciones->getFinOferta($row['id']).'</strong></small></div>';
					}
					else
					{
						echo '<div class="pi-price">$'.number_format($funciones->getPrecio($row['id'],$_SESSION['tipousuario']),2,',','.').'<br><small>Precio Neto con IVA Incluido</small><br><small>&nbsp;</small></div>';
					}
				}
			}
					 if($funciones->esNuevo($row['id']))
			   {
				   echo '<div class="sticker sticker-new"></div>';
			   }
			     if((isset($_SESSION["cid"])) && ($_SESSION["tipousuario"]!="0")){
			   if($funciones->showPrices()){
              echo '<a href="#" onclick="addCart('.$row['id'].');" class="btn add2cart">Comprar</a>';
    }
}
    echo '</div>
        </div>';
		}
	
	?>
	
	
</div>
<div class="row" style="text-align: center;">
	
	<nav aria-label="Page navigation">
  <ul class="pagination">
    
   
    <?php
	//boton ATRAS
	if($paginaactual>1)
	{
		echo '<li>
      <a  href="search.php?keyword='.$_REQUEST['keyword'].'&auto='.$_REQUEST['auto'].'&modelo='.$_REQUEST['modelo'].'&p='.($paginaactual-1).'" aria-label="Previous">
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
			echo ' <li><a href="search.php?keyword='.$_REQUEST['keyword'].'&auto='.$_REQUEST['auto'].'&modelo='.$_REQUEST['modelo'].'&p='.($i+1).'">'.($i+1).'</a></li>';
		}
	}
	
	//boton SIGUIENTE
	if($paginaactual<$totalpaginas)
	{
		echo '<li>
      <a  href="search.php?keyword='.$_REQUEST['keyword'].'&auto='.$_REQUEST['auto'].'&modelo='.$_REQUEST['modelo'].'&p='.($paginaactual+1).'"  aria-label="Next">
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
    
    
      <?php
  include 'footer.php';
  ?>