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

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=$fila;$i<=$fila_fin;$i++){
$codigo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_codigo).$i)->getCalculatedValue();
$razonsocial = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_razonsocial).$i)->getCalculatedValue();
$cuit = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_cuit).$i)->getCalculatedValue();
$idsistema = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_idsistema).$i)->getCalculatedValue();
$telefono = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_telefono).$i)->getCalculatedValue();
$direccion = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_direccion).$i)->getCalculatedValue();
$localidad= $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_localidad).$i)->getCalculatedValue();
$provincia = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_provincia).$i)->getCalculatedValue();
$email = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_email).$i)->getCalculatedValue();
$tipo = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_tipo).$i)->getCalculatedValue();
$responsable = $objPHPExcel->getActiveSheet()->getCell(strtoupper($col_responsable).$i)->getCalculatedValue();
//si el codigo esta vacio, es insercion. sino modificacion
if(empty($codigo))
{
	$sql="insert into clientes values(NULL,'".$razonsocial."','".$cuit."','".$telefono."','".$direccion."','".$localidad."','".$provincia."','".$email."','123','".$tipo."','".$idsistema."','".$responsable."')";
}
else
{
	$sql="update clientes set razonsocial='".$razonsocial."',cuit='".$cuit."',telefono='".$telefono."',direccion='".$direccion."',localidad='".$localidad."',provincia='".$provincia."',email='".$email."',tipo='".$tipo."',idsistema='".$idsistema."',iva='".$responsable."' where idcliente=".$codigo;
}

$stmt = $dbh->prepare("$sql");
        $stmt->execute();
		

}
$errores=0;
echo '<div class="alert alert-success" role="alert">ARCHIVO IMPORTADO CON EXITO</div>';
unlink($destino);

include 'pages/excelclientes.tpl.php';
}
//si por algo no cargo el archivo bak_ 
else{
echo '<div class="alert alert-danger" role="alert">No se puede subir el archivo de Excel. Por favor, verifique los datos ingresados.</div>';
include 'pages/excelclientes.tpl.php';
}

}	
else{
include 'pages/excelclientes.tpl.php';
}
?>