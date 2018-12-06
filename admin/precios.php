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

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


        // Llenamos el arreglo con los datos  del archivo xlsx 
for ($i=$fila;$i<=$fila_fin;$i++){
$codigo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_codigo).$i)->getCalculatedValue();
$precio = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_nombre).$i)->getCalculatedValue();

$sql="update productos set precio='".$precio."' where codigo='".$codigo."'";
$stmt = $dbh->prepare("$sql");
        $stmt->execute();

}
$errores=0;

echo '<div class="alert alert-success" role="alert">ARCHIVO IMPORTADO CON EXITO</div>';
unlink($destino);
include 'pages/precios.tpl.php';
}
//si por algo no cargo el archivo bak_ 
else{
echo '<div class="alert alert-danger" role="alert">No se puede subir el archivo de Excel. Por favor, verifique los datos ingresados.</div>';
include 'pages/precios.tpl.php';
}

}	
elseif((isset($_POST['action']))&&($_POST['action'] == "precios")){
	$mostrar="0";
if(isset($_POST['mostrarprecio'])){$mostrar="1";}
$sql="update config set mostrarprecio='".$mostrar."'";
$stmt = $dbh->prepare("$sql");
        $stmt->execute();
        echo '<div class="alert alert-success" role="alert">Configuracion Guardada.</div>';
        include 'pages/precios.tpl.php';
}
else{
include 'pages/precios.tpl.php';
}
?>