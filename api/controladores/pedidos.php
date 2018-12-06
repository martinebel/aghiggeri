<?php

require_once('datos/ConexionBD.php');

class pedidos
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
		return self::getPedidos();
		}
        else
		{
            return self::getPedidos($peticion[0]);
		}

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
	
	 private function getPedidos($clientID = NULL)
    {
         if ($clientID) {
                $comando = "SELECT pedidos.id  as idpedido,clientes.idcliente,clientes.razonsocial,clientes.cuit,clientes.telefono,clientes.direccion,clientes.localidad,clientes.provincia,clientes.email,pedidos.fecha,pedidos.estado,pedidos.observaciones FROM pedidos inner join clientes on clientes.idcliente=pedidos.cliente WHERE pedidos.id=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                // Preparar sentencia
               
            }
			else{
				  $comando = "SELECT pedidos.id as idpedido,clientes.idcliente,clientes.razonsocial,clientes.cuit,clientes.telefono,clientes.direccion,clientes.localidad,clientes.provincia,clientes.email,pedidos.fecha,pedidos.estado,pedidos.observaciones FROM pedidos inner join clientes on clientes.idcliente=pedidos.cliente where estado='RECIBIDO'" ;
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
			}
			
			// Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else
                throw new ExcepcionApi(self::ESTADO_ERROR, "An error has been ocurred");
    }
	
private function actualizar($userID, $client)
    {
		$estado = $client->estado;
        try {
            // Creando consulta UPDATE
            
                   $consulta = "UPDATE pedidos SET estado='".$estado."' where id=".$userID;
                     
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
            echo $consulta;
				

            // Ejecutar la sentencia
            $sentencia->execute();

            return $sentencia->rowCount();
			
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }


}