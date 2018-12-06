<?php 
require '../db.php';
require_once('vendor/PHPExcel/Classes/PHPExcel.php');
if(isset($_POST['action']))
{
	switch($_POST['action']){
	case "productos":
	$archivo="ListadoProductos".date('d-m-Y').".xlsx";
	 $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Agustin Ghiggeri")
							 ->setTitle("Listado de Productos");

	$stmt = $dbh->prepare("SELECT productos.*,categorias.nombre as 'categoria' from categoriaproductos inner join productos on categoriaproductos.idproducto=productos.id inner join categorias on categorias.id=categoriaproductos.idcategoria");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		$contador=2;
		//encabezado
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CODIGO')
            ->setCellValue('B1', 'NOMBRE')
            ->setCellValue('C1', 'MARCA')
            ->setCellValue('D1', 'PRECIO')
			->setCellValue('E1', 'DESCRIPCION')
            ->setCellValue('F1', 'MARCA AUTO')
            ->setCellValue('G1', 'MODELO AUTO')
            ->setCellValue('H1', 'CATEGORIA')
			->setCellValue('I1', 'IMAGEN')
			->setCellValue('J1', 'DESC LARGA')
			->setCellValue('K1', 'FECHA ALTA')
			->setCellValue('L1', 'CANT OFERTA')
			->setCellValue('M1', 'DESCUENTO')
			->setCellValue('N1', 'STOCK');
		foreach($result as $row)
		{						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['codigo'])
			->setCellValue('B'.$contador, $row['nombre'])
			->setCellValue('C'.$contador, $row['marca'])
			->setCellValue('D'.$contador, $row['precio'])
			->setCellValue('E'.$contador, $row['descripcion'])
			->setCellValue('F'.$contador, $row['marcaauto'])
			->setCellValue('G'.$contador, $row['modeloauto'])
			->setCellValue('H'.$contador, $row['categoria'])
			->setCellValue('I'.$contador, $row['imagen'])
			->setCellValue('J'.$contador, $row['desclarga'])
			->setCellValue('K'.$contador, $row['fechaalta'])
			->setCellValue('L'.$contador, $row['cantoferta'])
			->setCellValue('M'.$contador, $row['descuento'])
			->setCellValue('N'.$contador, $row['stock']);
			$contador++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($archivo);
			echo '<div class="alert alert-success" role="alert">LISTADO CREADO CON EXITO. Puede descargarlo <a href="'.$archivo.'" target="_blank">haciendo click aqui</a></div>';
	break;
	case "categorias":
	 //select t1.nombre as 'Nombre', t1.padre, t2.nombre as 'N Padre' from categorias t1 inner join categorias t2 on t1.padre = t2.id
	 $archivo="ListadoCategorias".date('d-m-Y').".xlsx";
	 $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Agustin Ghiggeri")
							 ->setTitle("Listado de Categorias");

	
		$contador=2;
		//encabezado
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NOMBRE')
            ->setCellValue('B1', 'PADRE');
			//primero las raiz
			$stmt = $dbh->prepare("SELECT * from categorias where padre=0");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['nombre'])
			->setCellValue('B'.$contador, '');
			$contador++;
		}
		//ahora las demas
			$stmt = $dbh->prepare("select t1.nombre as 'nombre', t1.padre, t2.nombre as 'npadre' from categorias t1 inner join categorias t2 on t1.padre = t2.id order by t1.padre asc");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['nombre'])
			->setCellValue('B'.$contador, $row['npadre']);
			$contador++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($archivo);
			echo '<div class="alert alert-success" role="alert">LISTADO CREADO CON EXITO. Puede descargarlo <a href="'.$archivo.'" target="_blank">haciendo click aqui</a></div>';
	
	break;
	case "clientes":
	$archivo="ListadoClientes".date('d-m-Y').".xlsx";
	 $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Agustin Ghiggeri")
							 ->setTitle("Listado de Clientes");

	$stmt = $dbh->prepare("SELECT * from clientes");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		$contador=2;
		//encabezado
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID INTERNO')
			->setCellValue('B1', 'ID SISTEMA')
            ->setCellValue('C1', 'RAZON SOCIAL')
            ->setCellValue('D1', 'CUIT/DNI')
            ->setCellValue('E1', 'TELEFONO')
			->setCellValue('F1', 'DIRECCION')
			->setCellValue('G1', 'LOCALIDAD')
			->setCellValue('H1', 'PROVINCIA')
			->setCellValue('I1', 'EMAIL')
            ->setCellValue('J1', 'TIPO');
		foreach($result as $row)
		{						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['idcliente'])
			->setCellValue('B'.$contador, $row['idsistema'])
			->setCellValue('C'.$contador, $row['razonsocial'])
			->setCellValue('D'.$contador, $row['cuit'])
			->setCellValue('E'.$contador, $row['telefono'])
			->setCellValue('F'.$contador, $row['direccion'])
			->setCellValue('G'.$contador, $row['localidad'])
			->setCellValue('H'.$contador, $row['provincia'])
			->setCellValue('I'.$contador, $row['email'])
			->setCellValue('J'.$contador, $row['tipo']);
			$contador++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($archivo);
			echo '<div class="alert alert-success" role="alert">LISTADO CREADO CON EXITO. Puede descargarlo <a href="'.$archivo.'" target="_blank">haciendo click aqui</a></div>';
	
	break;
	
	case "ofertas":
	 //select t1.nombre as 'Nombre', t1.padre, t2.nombre as 'N Padre' from categorias t1 inner join categorias t2 on t1.padre = t2.id
	 $archivo="ListadoCategorias".date('d-m-Y').".xlsx";
	 $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Agustin Ghiggeri")
							 ->setTitle("Listado de Ofertas");

	
		$contador=2;
		//encabezado
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CODIGO')
            ->setCellValue('B1', 'FECHA INICIO')
			->setCellValue('C1', 'FECHA FIN')
			->setCellValue('D1', 'DESCUENTO');
			//primero las raiz
			$stmt = $dbh->prepare("SELECT * from ofertas");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['idproducto'])
			->setCellValue('B'.$contador,  $row['fechadesde'])
			->setCellValue('C'.$contador,  $row['fechahasta'])
			->setCellValue('D'.$contador,  $row['porcentaje']);
			$contador++;
		}
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($archivo);
			echo '<div class="alert alert-success" role="alert">LISTADO CREADO CON EXITO. Puede descargarlo <a href="'.$archivo.'" target="_blank">haciendo click aqui</a></div>';
	
	break;

	case 'imagenes':
	$archivo="ImagenesFaltantes".date('d-m-Y').".xlsx";
	 $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Agustin Ghiggeri")
							 ->setTitle("Informe de Imagenes Faltantes");

	
		$contador=2;
		//encabezado
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CODIGO')
            ->setCellValue('B1', 'ARCHIVO');
			//primero las raiz
			$stmt = $dbh->prepare("SELECT * from productos");
        $stmt->execute();
		$result = $stmt->fetchAll(); 
		foreach($result as $row)
		{		
		if(!empty($row["imagen"]))
			{
				$path_parts = pathinfo('../img/p/'.$row['imagen']);
				$file=$path_parts['filename'];
				//probar si existe con extension mayuscula
				$ext = strtoupper($path_parts['extension']);
				if(file_exists('../img/p/'.$file.".".$ext))
				{
					
				}
				elseif(file_exists('../img/p/'.$file.".".strtolower($ext)))
				{
					
				}
				else
			{
				$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['codigo'])
			->setCellValue('B'.$contador,  $row['imagen']);
			$contador++;
			}
			}
			else
			{
				$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row['codigo'])
			->setCellValue('B'.$contador,  '(vacio)');
			$contador++;
			}				 

			
		}
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($archivo);
			echo '<div class="alert alert-success" role="alert">LISTADO CREADO CON EXITO. Puede descargarlo <a href="'.$archivo.'" target="_blank">haciendo click aqui</a></div>';
	break;
    }


		

}

include 'pages/descargas.tpl.php';
?>