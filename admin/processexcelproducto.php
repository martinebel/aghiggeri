<?php
header('Content-Type: text/event-stream');
// recommended to prevent caching of event data.
header('Cache-Control: no-cache');

function send_message($id, $message, $progress) {
    $d = array('message' => $message , 'progress' => $progress);

    echo "id: $id" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;

    ob_flush();
    flush();
}

require '../db.php';
set_time_limit(0);
$fp = @fopen('excelproducto.txt', 'r');

// Add each line to an array
if ($fp) {
   $members = explode("\r\n", fread($fp, filesize('excelproducto.txt')));
}
fclose($fp);

////////////////////////////////////////////////////////
if (file_exists ($members[0])){
/** Clases necesarias */
require_once('vendor/PHPExcel/Classes/PHPExcel.php');
require_once('vendor/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');

//echo '<div style="width:100%;margin-top:5%;position:absolute;padding-left:40%;"><h3>Cargando... no cierre esta ventana.</h3><br><img src="assets/images/loadingBar.gif"></div>';

//vaciar la tabla de productos y categorias-productos
	/*$stmt = $dbh->prepare("delete from productos;truncate table productos;delete from categoriaproductos;");
        $stmt->execute();*/

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load($members[0]);
$objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=$members[1];$i<=$members[2];$i++){
$codigo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[3]).$i)->getCalculatedValue();
$nombre = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[4]).$i)->getCalculatedValue();
$marca = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[5]).$i)->getCalculatedValue();
$precio = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[6]).$i)->getCalculatedValue();
$descripcion = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[7]).$i)->getCalculatedValue();
$marcaauto = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[8]).$i)->getCalculatedValue();
$modeloauto= $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[9]).$i)->getCalculatedValue();
$categoria = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[10]).$i)->getCalculatedValue();
$imagen = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[11]).$i)->getCalculatedValue();
$desclarga = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[12]).$i)->getCalculatedValue();
$fechaalta = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[13]).$i)->getCalculatedValue();
$cantoferta = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[14]).$i)->getCalculatedValue();
$descuento = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[15]).$i)->getCalculatedValue();
$stock = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[16]).$i)->getCalculatedValue();
//insertar en productos
$sql="insert into productos values (NULL,'".$codigo."','".$nombre."','".$marca."','".$precio."','".$fechaalta."','".$descripcion."','".$marcaauto."','".$modeloauto."','".$imagen."','".$desclarga."','".$cantoferta."','".$descuento."','".$stock."');";
$stmt = $dbh->prepare("$sql");
        $stmt->execute();
		$idprod=$dbh->lastInsertId();
//insertar en la categoria
 $stmt = $dbh->prepare("SELECT * from categorias where nombre='".$categoria."'");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$idcat=$row['id'];
		}
	$stmt = $dbh->prepare("insert into categoriaproductos values (".$idprod.",".$idcat.")");
        $stmt->execute();

$porcentaje=number_format(100/$members[2]*$i,0);
  send_message($porcentaje, 'cargando ' . $i . ' de '.$members[2] , $porcentaje);
}

unlink($members[0]);
unlink("excelproducto.txt");
send_message('CLOSE', 'Process complete',100);
}



?>
