  <?php
  include 'header.php';
 
  ?>
    <div class="container" style=" padding-top: 20px;">
	
<br>
				
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Descargas</h3>
  </div>
  <div class="panel-body">
  
  <div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  <?php
  $contador=1;
  $stmt = $dbh->prepare("select categoriadescargas.nombre,categoriadescargas.idcategoria from descargas inner join categoriadescargas on categoriadescargas.idcategoria=descargas.categoria group by nombre,idcategoria  order by idcategoria asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		
		foreach($result as $row)
		{
			if($contador==1)
			{
				 echo '<li role="presentation" class="active"><a href="#cat'.$row['idcategoria'].'" aria-controls="cat'.$row['idcategoria'].'" role="tab" data-toggle="tab">'.$row['nombre'].'</a></li>';
			}
			else
			{
				echo '<li role="presentation"><a href="#cat'.$row['idcategoria'].'" aria-controls="cat'.$row['idcategoria'].'" role="tab" data-toggle="tab">'.$row['nombre'].'</a></li>';
			}
			$contador++;
		}
  
  ?>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   <?php
   $contador=1;$categoria="";
	$stmt = $dbh->prepare("select * from descargas order by categoria asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		
		foreach($result as $row)
		{
			if($categoria!=$row['categoria'])
			{
				if($categoria!=""){echo '</div>';}
				
				
				$categoria=$row['categoria'];
				if($contador==1)
				{
					echo '<div role="tabpanel" class="tab-pane active" id="cat'.$row['categoria'].'"><br>';
				}
				else
				{
					echo '<div role="tabpanel" class="tab-pane" id="cat'.$row['categoria'].'"><br>';
				}
				$contador++;
			}
			echo '<div class="col-md-3 col-xs-12"><a style="width:100%;" href="descargas/'.$row['archivo'].'" target="_blank" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;'.$row['nombre'].'</a></div>';
		}
	?>
    </div>
  </div>

</div>
	
  </div>
</div>			
					
				</div>
			
      <?php
  include 'footer.php';
  ?>
  
  
  
  
  
  
  
 