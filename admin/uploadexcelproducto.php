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
		$myFile2 = "excelproducto.txt";
		$myFileLink2 = fopen($myFile2, 'w+') or die("Can't open file.");
		fwrite($myFileLink2, "bak_".$archivo.PHP_EOL);
		fwrite($myFileLink2, $fila.PHP_EOL);
		fwrite($myFileLink2, $fila_fin.PHP_EOL);

		fwrite($myFileLink2, $col_codigo.PHP_EOL);
		fwrite($myFileLink2, $col_nombre.PHP_EOL);
		fwrite($myFileLink2, $col_marca.PHP_EOL);
		fwrite($myFileLink2, $col_precio.PHP_EOL);
		fwrite($myFileLink2, $col_desc.PHP_EOL);
		fwrite($myFileLink2, $col_marcaauto.PHP_EOL);
		fwrite($myFileLink2, $col_modeloauto.PHP_EOL);
		fwrite($myFileLink2, $col_categoria.PHP_EOL);
		fwrite($myFileLink2, $col_imagen.PHP_EOL);
		fwrite($myFileLink2, $col_desclarga.PHP_EOL);
		fwrite($myFileLink2, $col_fecha.PHP_EOL);
		fwrite($myFileLink2, $col_cantoferta.PHP_EOL);
		fwrite($myFileLink2, $col_descuento.PHP_EOL);
		fwrite($myFileLink2, $col_stock.PHP_EOL);
		fclose($myFileLink2);
	 }
	else {echo "ERROR";}
}







?>
