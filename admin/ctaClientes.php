<?php 
require '../db.php';
$mensaje="";
extract($_POST);
if ((isset($_POST['action']))&&($_POST['action'] == "upload")){
$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "";
	else echo '<div class="alert alert-danger">Error Al Cargar el Archivo</div>';
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)){ 
	//borrar los anteriores
	$files = glob('../ctacte/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
//cargar los nuevos
$zip = new ZipArchive;
if ($zip->open("bak_".$archivo) === TRUE) {
    $zip->extractTo('../ctacte/');
    $zip->close();
    echo '<div class="alert alert-succes">Carga Completada con Exito</div>';
} else {
    echo '<div class="alert alert-danger">Error en la Carga</div>';
}             
}
}
include 'pages/ctaClientes.tpl.php';
?>

