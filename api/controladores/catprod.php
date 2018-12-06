<?php

require_once('datos/ConexionBD.php');

class catprod
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
		 throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta Codigo Producto", 422);
		}
        else
		{
			$clientID = productos::getIDByCodigo($peticion[0]);
            return self::getCategorias($clientID);
		}

    }
	
	    public static function post()
    {

            return self::registrar();
		
        
    }
	
	public static function delete($peticion)
    {
       
        if (!empty($peticion[0])) {
			$clientID = productos::getIDByCodigo($peticion[0]);
            self::eliminar($clientID);
                http_response_code(200);
                return [
                    "mensaje" => "Registros eliminados correctamente"
                ];
            
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta id producto", 422);
        }

    }
	
	 private function eliminar($clientID)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM categoriaproductos where idproducto=?";

            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

            $sentencia->bindParam(1, $clientID);

            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
	
	  
	
	 private function getCategorias($clientID)
    {
         
                $comando = "SELECT idcategoria,categorias.nombre FROM categoriaproductos inner join categorias on categorias.id=categoriaproductos.idcategoria WHERE idproducto=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                // Preparar sentencia
               
            
			
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
        $idp = $datosUsuario->idproducto;
		$idproducto=productos::getIDByCodigo($idp);
        $idcategoria = $datosUsuario->idcategoria;

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

			
            // Sentencia INSERT
            $comando = "INSERT INTO categoriaproductos (idcategoria,idproducto) VALUES(?,?)";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $idcategoria);
            $sentencia->bindParam(2, $idproducto);

            $resultado = $sentencia->execute();
	

            if ($resultado) {
				$respuesta["idcategoria"] =  $idcategoria;
                $respuesta["idproducto"] = $idproducto;
                return [$respuesta];
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }

    }


}