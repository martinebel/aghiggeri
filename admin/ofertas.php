<?php 
require '../db.php';
$mensaje="";
extract($_POST);

if ((isset($_POST['action']))&&($_POST['action'] == "upload")){
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "";
	else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)){ 
/** Clases necesarias */
require_once('vendor/PHPExcel/Classes/PHPExcel.php');
require_once('vendor/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');

//echo '<div style="width:100%;margin-top:5%;position:absolute;padding-left:40%;"><h3>Cargando... no cierre esta ventana.</h3><br><img src="assets/images/loadingBar.gif"></div>';
//vaciar la tabla de productos y categorias-productos
$stmt = $dbh->prepare("delete from ofertas;");
        $stmt->execute();
// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


        // Llenamos el arreglo con los datos  del archivo xlsx 
for ($i=$fila;$i<=$fila_fin;$i++){
$codigo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_codigo).$i)->getCalculatedValue();
$finicio = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_finicio).$i)->getCalculatedValue();
$ffin = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_ffin).$i)->getCalculatedValue();
$descuento = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_descuento).$i)->getCalculatedValue();

$sql="insert into ofertas values ('".$codigo."','".$finicio."','".$ffin."','".$descuento."');";
$stmt = $dbh->prepare("$sql");
        $stmt->execute();

}
$errores=0;

echo '<div class="alert alert-success" role="alert">ARCHIVO IMPORTADO CON EXITO</div>';
unlink($destino);
include 'pages/ofertas.tpl.php';
}
//si por algo no cargo el archivo bak_ 
else{
echo '<div class="alert alert-danger" role="alert">No se puede subir el archivo de Excel. Por favor, verifique los datos ingresados.</div>';
include 'pages/ofertas.tpl.php';
}

}	
else{
include 'pages/ofertas.tpl.php';
}
?>
