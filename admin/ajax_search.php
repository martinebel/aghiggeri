<?php
require '../db.php';
//busqueda ajax de cliente
if(isset($_REQUEST['term'])) {
$name=$_REQUEST["term"];

$html="";
  $return = array();
    $json = "[";
    $first = true;

$query="SELECT * from productos where nombre like '%".$name."%' or  codigo like '%".$name."%' limit 0,10";
  $stmt = $dbh->prepare("$query");
        $stmt->execute(); 
          $result = $stmt->fetchAll(); 
    foreach($result as $row){
                


      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"id":"'.$row['id'].'","label":"['.$row['codigo'].'] '.$row['nombre'].'","value":"'.$row['nombre'].'"}';
	
     }


    $json .= "]";

    echo $json;
  
}

//consulta de datos de cliente
if(isset($_REQUEST['codigo'])) {
	$html="";
  $return = array();
    $json = "[";
    $first = true;

$query="SELECT * from productos where id=".$_REQUEST['codigo']."";
  $stmt = $dbh->prepare("$query");
        $stmt->execute(); 
          $result = $stmt->fetchAll(); 
	$output_array = array();	  
 foreach($result as $row) {
    $output_array[] = array( 'id' => $row['id'], 'codigo' => $row['codigo'], 'nombre' => $row['nombre'], 'imagen' => $row['imagen'] );
}

echo json_encode( $output_array );
}
?>