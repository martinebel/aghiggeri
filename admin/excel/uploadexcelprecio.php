<?php

extract($_POST);
set_time_limit(0);

//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_
if(isset($_FILES['excel']['name'])){
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)){
		$myFile2 = "excelprecio.txt";
		$myFileLink2 = fopen($myFile2, 'w+') or die("Can't open file.");
		fwrite($myFileLink2, "bak_".$archivo.PHP_EOL);
		fwrite($myFileLink2, $fila.PHP_EOL);
		fwrite($myFileLink2, $fila_fin.PHP_EOL);

		fwrite($myFileLink2, $col_codigo.PHP_EOL);
		fwrite($myFileLink2, $col_nombre.PHP_EOL);
		fclose($myFileLink2);
		header('Location: progresoexcelprecio.php');
	 }
	else {echo "ERROR";}
}







?>
