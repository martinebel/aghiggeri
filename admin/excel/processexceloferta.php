<?php
set_time_limit(0);
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

require '../../db.php';
set_time_limit(0);
$fp = @fopen('exceloferta.txt', 'r');

// Add each line to an array
if ($fp) {
   $members = explode("\n", fread($fp, filesize('exceloferta.txt')));
}
fclose($fp);

////////////////////////////////////////////////////////
if (file_exists ($members[0])){
/** Clases necesarias */
require_once('../vendor/PHPExcel/Classes/PHPExcel.php');
require_once('../vendor/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');

//echo '<div style="width:100%;margin-top:5%;position:absolute;padding-left:40%;"><h3>Cargando... no cierre esta ventana.</h3><br><img src="assets/images/loadingBar.gif"></div>';

$stmt = $dbh->prepare("delete from ofertas;");
        $stmt->execute();

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load($members[0]);
$objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=$members[1];$i<=$members[2];$i++){
$codigo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[3]).$i)->getCalculatedValue();
$finicio = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[4]).$i)->getCalculatedValue();
$ffin = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[5]).$i)->getCalculatedValue();
$descuento = $objPHPExcel->getActiveSheet()->getCell(strtoupper($members[6]).$i)->getCalculatedValue();

//insertar en productos
$sql="insert into ofertas values ('".$codigo."','".$finicio."','".$ffin."','".$descuento."');";
$stmt = $dbh->prepare("$sql");
        $stmt->execute();

$porcentaje=number_format(100/$members[2]*$i,0);
  send_message($porcentaje, 'cargando ' . $i . ' de '.$members[2] , $porcentaje);
}

unlink($members[0]);
unlink("exceloferta.txt");
send_message('CLOSE', 'Process complete',100);
}
else {
  {
send_message('1','file not found',1);
  }
}


?>
