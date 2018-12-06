<?php

require_once('datos/ConexionBD.php');

class detallepedido
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
		throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta Codigo Pedido", 422);
		}
        else
		{
            return self::getPedidos($peticion[0]);
		}

    }
	
	
	 private function getPedidos($clientID)
    {
        
                $comando = "SELECT productos.id as idproducto, productos.codigo,detallepedidos.cant,detallepedidos.precio from detallepedidos inner join productos on productos.id=detallepedidos.idproducto where detallepedidos.idpedido=?";
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
	



}