<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class loginModelo{
	
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function iniciarSesion($usuario,$password){
		$sql = "SELECT * FROM usuario WHERE (usuario = '$usuario' AND password = '$password') OR (correo = '$usuario' AND password = '$password') AND activo = 1 ";
		$res = $this->conexion->mostrarSQL($sql);
		$row = $res->rowCount();
		if($row > 0){
			return $res;
		}else{
			return false;
		}
	}

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
