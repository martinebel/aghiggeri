  <?php
  include 'header.php';
  ?>
    
<div class="container" style="    padding-top: 10px; width:100%;margin-left:0px;margin-right:0px;">
	 <div class="col-md-12">
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
<div class="col-md-9">		
<table class="table table-striped">
	<thead>
	<tr><th>Fecha</th><th>Importe</th><th></th>
	</thead>
	<tbody>
	<?php
	$stmt = $dbh->prepare( "SELECT * from temp_pedidos_header where idcliente=".$_SESSION['cid']." and clave<>'".$_SESSION['uid']."'");
 $stmt->execute();
		$result = $stmt->fetchAll(); 
			
foreach($result as $row)
		{
			echo '<tr><td>'.$row['fecha'].'</td><td>$'.number_format($row['total'],2).'</td><td><a class="btn btn-default" href="#" onclick="reloadTemp(\''.$row['clave'].'\');"><i class="fa fa-refresh" aria-hidden="true"></i> Continuar</a></td></tr>';
		}
		?>
		</tbody>
		</table>
	
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
  