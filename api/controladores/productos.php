<?php

require_once('datos/ConexionBD.php');

class productos
{
    
    const ESTADO_CREACION_EXITOSA = 1;
    const ESTADO_CREACION_FALLIDA = 2;
    const ESTADO_ERROR_BD = 3;
    const ESTADO_AUSENCIA_CLAVE_API = 4;
    const ESTADO_CLAVE_NO_AUTORIZADA = 5;
    const ESTADO_URL_INCORRECTA = 6;
    const ESTADO_FALLA_DESCONOCIDA = 7;
    const ESTADO_PARAMETROS_INCORRECTOS = 8;
		const ESTADO_ERROR_PARAMETROS = 9;
	const ESTADO_ERROR = 10;
	
	
   public static function get($peticion)
    {

        if (empty($peticion[0]))
		{
		return self::getProductos();
		}
        else
		{
            return self::getProductos($peticion[0]);
		}

    }
	
	    public static function post()
    {

            return self::registrar();
		
        
    }
	
	   public static function put($peticion)
    {
        $userID = $peticion[0];
		//echo "ID:".$userID;

        if (!empty($peticion[0])) {
            $body = file_get_contents('php://input');
            $client = json_decode($body);

			http_response_code(200);
                return [
                    "FilasModificadas" => self::actualizar($userID, $client)
                ];
           
              
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta Codigo", 422);
        }
    }
	
	 public static function getIDByCodigo($codigo)
    {
		 $comando = "SELECT id from productos where codigo=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $codigo, PDO::PARAM_INT);
                // Preparar sentencia
               
            
			
			// Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                $resultado = $sentencia->fetch();
            return $resultado['id'];

            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "An error has been ocurred");
    }

	
	 private function actualizar($userID, $client)
    {
		
        try {
			
            // Creando consulta UPDATE
			$parame='';
			if(isset($client->nombre)){$parame.="nombre='".$client->nombre."',";}
			if(isset($client->marca)){$parame.="marca='".$client->marca."',";}
			if(isset($client->precio)){$parame.="precio='".$client->precio."',";}
			if(isset($client->fechaalta)){$parame.="fechaalta='".$client->fechaalta."',";}
			if(isset($client->descripcion)){$parame.="descripcion='".$client->descripcion."',";}
			if(isset($client->marcaauto)){$parame.="marcaauto='".$client->marcaauto."',";}
			if(isset($client->modeloauto)){$parame.="modeloauto='".$client->modeloauto."',";}
			if(isset($client->imagen)){$parame.="imagen='".$client->imagen."',";}
			if(isset($client->desclarga)){$parame.="desclarga='".$client->desclarga."',";}
			if(isset($client->cantoferta)){$parame.="cantoferta='".$client->cantoferta."',";}
			if(isset($client->descuento)){$parame.="descuento='".$client->descuento."',";}
			if(isset($client->stock)){$parame.="stock='".$client->stock."',";}
			$consulta="update productos set ".trim($parame,',')." where codigo='".$userID."'";
			
			 $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
            
            /* $consulta = "UPDATE productos SET nombre=?,marca=?,precio=?,fechaalta=?,descripcion=?,marcaauto=?,modeloauto=?,imagen=?,desclarga=?,cantoferta=?,descuento=? where codigo=?";
                     
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
            
                $sentencia->bindParam(1, $nombre);
                $sentencia->bindParam(2, $marca);
                $sentencia->bindParam(3, $precio);
                $sentencia->bindParam(4, $fechaalta);
                $sentencia->bindParam(5, $descripcion);
                $sentencia->bindParam(6, $marcaauto);
                $sentencia->bindParam(7, $modeloauto);
                $sentencia->bindParam(8, $imagen);
                $sentencia->bindParam(9, $desclarga);
                $sentencia->bindParam(10, $cantoferta);
                $sentencia->bindParam(11, $descuento);
                $sentencia->bindParam(12, $userID);
                

				$nombre = $client->nombre;
                $marca = $client->marca;
                $precio = $client->precio;
                $fechaalta = $client->fechaalta;
                $descripcion = $client->descripcion; 
                $marcaauto = $client->marcaauto;
                $modeloauto = $client->modeloauto;
                $imagen = $client->imagen;
                $desclarga = $client->desclarga;
                $cantoferta = $client->cantoferta;
                $descuento = $client->descuento;*/

            // Ejecutar la sentencia
            $sentencia->execute();

            return $sentencia->rowCount();
			
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
	
	 private function getProductos($clientID = NULL)
    {
         if ($clientID) {
                $comando = "SELECT * FROM productos WHERE codigo=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                // Preparar sentencia
               
            }
			else{
				  $comando = "SELECT * FROM productos" ;
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
			}
			
			// Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "An error has been ocurred");
    }
	


	
	

    /**
     * Crea un nuevo usuario en la base de datos
     */
    private function registrar()
    {
       
        $cuerpo = file_get_contents('php://input');
        $usuario = json_decode($cuerpo);

        $resultado = self::crear($usuario);
		
        switch ($resultado) {
           
            case self::ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(self::ESTADO_CREACION_FALLIDA, "Ha ocurrido un error");
                break;
            default:
                  http_response_code(201);
                return $resultado;
        }
    }


    /**
     * Crea un nuevo usuario en la tabla "usuario"
     * @param mixed $datosUsuario columnas del registro
     * @return int codigo para determinar si la inserción fue exitosa
     */
    private function crear($datosUsuario)
    
    {    
        $codigo = $datosUsuario->codigo;
        $nombre = $datosUsuario->nombre;
		$marca = $datosUsuario->marca;
		$precio = $datosUsuario->precio;
		$fechaalta = $datosUsuario->fechaalta;
		$descripcion = $datosUsuario->descripcion;
		$marcaauto = $datosUsuario->marcaauto;
		$modeloauto = $datosUsuario->modeloauto;
		$imagen = $datosUsuario->imagen;
		$desclarga = $datosUsuario->desclarga;
		$cantoferta = $datosUsuario->cantoferta;
		$descuento = $datosUsuario->descuento;
		$stock = $datosUsuario->stock;

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO productos (id,codigo,nombre,marca,precio,fechaalta,descripcion,marcaauto,modeloauto,imagen,desclarga,cantoferta,descuento,stock) VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $codigo);
            $sentencia->bindParam(2, $nombre);
			$sentencia->bindParam(3, $marca);
			$sentencia->bindParam(4, $precio);
            $sentencia->bindParam(5, $fechaalta);
			$sentencia->bindParam(6, $descripcion);
			$sentencia->bindParam(7, $marcaauto);
            $sentencia->bindParam(8, $modeloauto);
			$sentencia->bindParam(9, $imagen);
			$sentencia->bindParam(10, $desclarga);
            $sentencia->bindParam(11, $cantoferta);
			$sentencia->bindParam(12, $descuento);
			$sentencia->bindParam(13, $stock);

            $resultado = $sentencia->execute();
	

            if ($resultado) {
				$respuesta["idproducto"] =  $pdo->lastInsertId();;
                $respuesta["codigo"] = $codigo;
                return [$respuesta];
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }

    }


}