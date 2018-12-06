<?php 
require '../db.php';
$mensaje="";
extract($_POST);
if ((isset($_POST['action']))&&($_POST['action'] == "upload")){
$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "";
	else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)){ 
$zip = new ZipArchive;
if ($zip->open("bak_".$archivo) === TRUE) {
    $zip->extractTo('../img/p/');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}             
}
}
include 'pages/subirimagenes.tpl.php';
?>

