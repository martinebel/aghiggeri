<?php

require_once('datos/ConexionBD.php');

class clientes
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
		return self::getClientes();
		}
        else
		{
            return self::getClientes($peticion[0]);
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
	
	 private function actualizar($userID, $client)
    {
		
        try {
			
            // Creando consulta UPDATE
			$parame='';
			if(isset($client->razonsocial)){$parame.="razonsocial='".$client->razonsocial."',";}
			if(isset($client->cuit)){$parame.="cuit='".$client->cuit."',";}
			if(isset($client->iva)){$parame.="iva='".$client->iva."',";}
			if(isset($client->telefono)){$parame.="telefono='".$client->telefono."',";}
			if(isset($client->direccion)){$parame.="direccion='".$client->direccion."',";}
			if(isset($client->localidad)){$parame.="localidad='".$client->localidad."',";}
			if(isset($client->provincia)){$parame.="provincia='".$client->provincia."',";}
			if(isset($client->email)){$parame.="email='".$client->email."',";}
			if(isset($client->tipo)){$parame.="tipo='".$client->tipo."',";}
			if(isset($client->idsistema)){$parame.="idsistema='".$client->idsistema."',";}
			
			$consulta="update clientes set ".trim($parame,',')." where idcliente='".$userID."'";
             $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
                   /*$consulta = "UPDATE clientes SET razonsocial=?,cuit=?,telefono=?,direccion=?,localidad=?,provincia=?,email=?,tipo=?,idsistema=? where idcliente=?";
                     
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);
            
                $sentencia->bindParam(1, $razonsocial);
                $sentencia->bindParam(2, $cuit);
                $sentencia->bindParam(3, $telefono);
                $sentencia->bindParam(4, $direccion);
                $sentencia->bindParam(5, $localidad);
                $sentencia->bindParam(6, $provincia);
                $sentencia->bindParam(7, $email);
                $sentencia->bindParam(8, $tipo);
                $sentencia->bindParam(9, $idsistema);
                $sentencia->bindParam(10, $userID);
                

				$razonsocial = $client->razonsocial;
                $cuit = $client->cuit;
                $telefono = $client->telefono;
                $direccion = $client->direccion;
                $localidad = $client->localidad; 
                $provincia = $client->provincia;
                $email = $client->email;
                $tipo = $client->tipo;
				$idsistema = $client->idsistema;*/

            // Ejecutar la sentencia
            $sentencia->execute();

            return $sentencia->rowCount();
			
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
	
	 private function getClientes($clientID = NULL)
    {
         if ($clientID) {
                $comando = "SELECT * FROM clientes WHERE cuit=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                // Preparar sentencia
               
            }
			else{
				  $comando = "SELECT * FROM clientes" ;
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
	
	 private function getClientesByCuit($clientID)
    {
       
                $comando = "SELECT * FROM clientes WHERE cuit=?";
                    $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Relacionar idPediatra e idUsuario
                $sentencia->bindParam(1, $clientID, PDO::PARAM_INT);
                $sentencia->execute();
				$contador=$sentencia->rowCount();
			// Ejecutar sentencia preparada
            if ($contador>0) {
                 $resultado = $sentencia->fetch();
					$respuesta["idcliente"] =  $resultado["idcliente"];
                $respuesta["razonsocial"] = $resultado["razonsocial"];
                return [$respuesta];
            } else
                return 0;
    }


    /**
     * Crea un nuevo usuario en la tabla "usuario"
     * @param mixed $datosUsuario columnas del registro
     * @return int codigo para determinar si la inserción fue exitosa
     */
    private function crear($datosUsuario)
    
    {    
        $razonsocial = $datosUsuario->razonsocial;
        $cuit = $datosUsuario->cuit;
		$telefono = $datosUsuario->telefono;
		$direccion = $datosUsuario->direccion;
		$localidad = $datosUsuario->localidad;
		$provincia = $datosUsuario->provincia;
		$email = $datosUsuario->email;
		$tipo = $datosUsuario->tipo;
		$iva = $datosUsuario->iva;
		$idsistema = $datosUsuario->idsistema;
		$password='123';
		$test=self::getClientesByCuit($cuit);
		if($test!=0)
		{
			http_response_code(201);
			return $test;
				exit();
		}
        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO clientes (idcliente,razonsocial,cuit,telefono,direccion,localidad,provincia,email,password,tipo,idsistema,iva) VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?)";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $razonsocial);
            $sentencia->bindParam(2, $cuit);
			$sentencia->bindParam(3, $telefono);
			$sentencia->bindParam(4, $direccion);
            $sentencia->bindParam(5, $localidad);
			$sentencia->bindParam(6, $provincia);
			$sentencia->bindParam(7, $email);
            $sentencia->bindParam(8, $password);
			$sentencia->bindParam(9, $tipo);
			$sentencia->bindParam(10, $idsistema);
			$sentencia->bindParam(11, $iva);

            $resultado = $sentencia->execute();
	

            if ($resultado) {
				$respuesta["idcliente"] =  $pdo->lastInsertId();;
                $respuesta["razonsocial"] = $razonsocial;
                return [$respuesta];
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }

    }


}