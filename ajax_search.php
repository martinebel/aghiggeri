<?php 
require 'db.php';
if(isset($_REQUEST['term'])) {
$name=trim(strtoupper($_REQUEST["term"]));

$input=array();
$listapalabras = explode(" ", $name);
			foreach($listapalabras as $cat){
				array_push($input, trim(strtoupper($cat)));
			}

// array de palabras contra las cuales verificar
$words  = array();
//aca armo el diccionario
$query="select nombre from productos";
 $stmt = $dbh->prepare("$query");
        $stmt->execute(); 
          $result = $stmt->fetchAll(); 
    foreach($result as $row){
		$listapalabras = explode(" ", $row['nombre']);
			foreach($listapalabras as $cat){
				array_push($words, trim(strtoupper($cat)));
			}

	}
// no se ha encontrado la distancia más corta, aun
$shortest = -1;
$final="";
// bucle a través de las palabras para encontrar la más cercana
foreach ($words as $word) {
foreach ($input as $palabra) {
    // calcula la distancia entre la palabra de entrada
    // y la palabra actual
    $lev = levenshtein(trim($palabra), trim($word));

    // verifica por una coincidencia exacta
    if ($lev == 0) {

        // la palabra más cercana es esta (coincidencia exacta)
        $closest = $word;
        $shortest = 0;

        // salir del bucle, se ha encontrado una coincidencia exacta
        break;
    }

    // si esta distancia es menor que la siguiente distancia
    // más corta o si una siguiente palabra más corta aun no se ha encontrado
    if ($lev <= $shortest || $shortest < 0) {
        // establece la coincidencia más cercana y la distancia más corta
        $closest  = $word;
        $shortest = $lev;
		$final=$palabra;
    }
	
}
}

//echo "Input word: $input\n";
if ($shortest == 0) {

} else {

	$name= str_replace($final,$closest,$name);
	
}
$html="";
  $return = array();
    $json = "[";
    $first = true;

/*$query="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$name)."') AS relevance FROM productos WHERE MATCH (codigo,descripcion) AGAINST ('".str_replace(' ','+',$name)."') or codigo like '%".$name."%' or descripcion like '%".$name."%' ORDER BY relevance DESC limit 0,10";*/
$query="SELECT productos.*, MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$name)."' IN BOOLEAN MODE) as rel 
FROM (`productos`) 
WHERE MATCH (codigo,descripcion) AGAINST ('+".str_replace(' ','+',$name)."' IN BOOLEAN MODE) 
ORDER BY `rel` DESC limit 10";
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
        $imgFinal="";
              if(!empty($row["imagen"]))
            {
                $path_parts = pathinfo('./img/p/'.$row['imagen']);
                $file=$path_parts['filename'];
                //probar si existe con extension mayuscula
                $ext = strtoupper($path_parts['extension']);
                if(file_exists('./img/p/'.$file.".".$ext))
                {
                   $imgFinal=$file.".".$ext;
                }
                elseif(file_exists('./img/p/'.$file.".".strtolower($ext)))
                {
                   $imgFinal=$file.".".strtolower($ext);
                }
                else
            {
               $imgFinal="default.jpeg";
            }
            }
            else
            {
                $imgFinal="default.jpeg";
            }

        $json .= '{"id":"'.$row['id'].'","label":"'.$row['descripcion'].'","value":"'.$row['descripcion'].'","icon":"./img/p/'.$imgFinal.'"}';
	
     }


    $json .= "]";

    echo $json;
  
}

if(isset($_REQUEST["action"]))
{
	$html="";
  $return = array();
    $json = "[";
    $first = true;

$stmt = $dbh->prepare("SELECT productos.modeloauto from productos where marcaauto='".$_REQUEST['clave']."' group by modeloauto order by modeloauto asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{
                


      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"modelo":"'.$row['modeloauto'].'"}';
	
     }


    $json .= "]";

    echo $json;
}
?>