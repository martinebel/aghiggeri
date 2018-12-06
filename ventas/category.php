  <?php
  include 'header.php';
  ?>
  
  <?php
	
	$stmt = $dbh->prepare("select * from categorias where id=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			$padre=$row['padre'];
			$nombre=$row['nombre'];
		}
		echo '<ol class="breadcrumb"  style="margin-bottom:0px;">
  <li><a href="index.php">INICIO</a></li>';
		
			echo '<li class="active">'.strtoupper($nombre).'</li>';
		
		echo '</ol>';
	?>
<div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
	<div class="row">
	
	<!------------------------>
	<div class="hidden-xs col-md-3">
	 <div class="well" style="padding: 0px 0;">
            <div style=" overflow-x: hidden;">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	
	 <?php
				  //traer categorias del mismo nivel que esta
				  
		
		$stmt = $dbh->prepare("select * from categorias where padre=0");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
			echo '<div class="panel panel-default">';
			echo ' <div class="panel-heading" role="tab" id="heading'.$row['id'].'">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row['id'].'" aria-expanded="true" aria-controls="collapse'.$row['id'].'">
          <label class="tree-toggler nav-header">'.$row['nombre'].' <i class="fa fa-plus fa-pull-right" aria-hidden="true"></i></label>
        </a>
     </h4>
    </div>
	 <div id="collapse'.$row['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$row['id'].'">
      <div class="panel-body"> <ul class="nav nav-list">';
			
					  $stmt2 = $dbh->prepare("select * from categorias where padre=".$row['id']);
        $stmt2->execute();
		$result2 = $stmt2->fetchAll(); 
		foreach($result2 as $row2)
		{
			echo ' <li><a href="category.php?id='.$row2['id'].'">'.strtoupper($row2['nombre']).'</a></li>';
		}
		echo ' </ul></div>
  </div>';
			echo '</div>';
		}
		?>
		
  </div>
  </div>
  </div>
  </div>
	
<!------------------------>
		
	
	
	<div class="col-md-9 col-xs-12">
	<legend><?php echo $nombre; ?></legend>
	<div class="row " >
 
		    <?php
				  //traer categorias hijas
		 $stmt = $dbh->prepare("select * from categorias where padre=".$_REQUEST['id']);
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		if($stmt->rowCount()==0)
		{
			//si no tiene hijos, ir directamente al listado de productos
			echo '<script>window.location.href="productlist.php?id='.$_REQUEST['id'].'";</script>';
		}
		
		foreach($result as $row)
		{
			//buscar una imagen de un producto en esta categoria
			$stmt = $dbh->prepare("select  productos.imagen from categoriaproductos inner join productos on productos.id=categoriaproductos.idproducto where imagen <>'' and idcategoria=".$row['id']." limit 1");
        $stmt->execute();
		$result2 = $stmt->fetchAll(); 
		if($stmt->rowCount()==0)
		{
			$imagen='c/'.$row['id'].'.jpg';
		}
		foreach($result2 as $row2)
		{
			$imagen='p/'.$row2['imagen'];
		}
			echo '<div class="col-md-4">
           <div class="product-item">
              <div class="pi-img-wrapper">
                <img src="img/'.$imagen.'" onerror="this.src=\'default.jpeg\';" class="img-responsive">
				<div>
                   <a href="productlist.php?id='.$row['id'].'" class="btn">Ver Mas</a>
                </div>
              </div>
              <h3><a href="productlist.php?id='.$row['id'].'">'.$row['nombre'].'</a></h3>
            </div>
        </div>';
		}
		?>
		
		
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