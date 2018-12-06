<?php

require_once('datos/ConexionBD.php');

class categorias
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
		return self::getCategorias();
		}
        else
		{
            return self::getCategorias($peticion[0]);
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

            if (self::actualizar($userID, $client) > 0) {
                http_response_code(200);
                return [
                    "mensaje" => "Registro actualizado correctamente"
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "La Categoria no existe", 404);
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta Codigo", 422);
        }
    }
	
	 private function actualizar($userID, $client)
    {
		
        try {
            // Creando consulta UPDATE
            
                   $consulta = "UPDATE categorias SET nombre=?,padre=? where id=?";
                     
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
            
                $sentencia->bindParam(1, $nombre);
                $sentencia->bindParam(2, $padre);
                $sentencia->bindParam(3, $userID);
                

				$nombre = $client->nombre;
                $padre = $client->padre;

            // Ejecutar la sentencia
            $sentencia->execute();

            return $sentencia->rowCount();
			
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
	
	 private function getCategorias($clientID = NULL)
    {
         if ($clientID) {
                $comando = "SELECT * FROM categorias WHERE id=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                // Preparar sentencia
               
            }
			else{
				  $comando = "SELECT * FROM categorias" ;
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
        $nombre = $datosUsuario->nombre;
        $padre = $datosUsuario->padre;

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO clientes (id,nombre,padre) VALUES(NULL,?,?)";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $padre);

            $resultado = $sentencia->execute();
	

            if ($resultado) {
				$respuesta["idcategoria"] =  $pdo->lastInsertId();;
                $respuesta["nombre"] = $nombre;
                return [$respuesta];
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }

    }


}