<?php 
require '../db.php';
if(isset($_REQUEST['term'])) {
$name=trim(strtoupper($_REQUEST["term"]));

$html="";
  $return = array();
    $json = "[";
    $first = true;

/*$query="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$name)."') AS relevance FROM productos WHERE MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$name)."') or codigo like '%".$name."%' or descripcion like '%".$name."%' ORDER BY relevance DESC limit 0,10";*/
$query="SELECT * from clientes where razonsocial like '%".$_REQUEST["term"]."%'";
//echo $query;
 $stmt = $dbh->prepare("$query");
        $stmt->execute(); 
          $result = $stmt->fetchAll(); 
    foreach($result as $row){
                


      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"id":"'.$row['idcliente'].'","label":"'.$row['razonsocial'].'","value":"'.$row['razonsocial'].'"}';
	
     }


    $json .= "]";

    echo $json;
  
}

?>