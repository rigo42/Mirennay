<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class loginModelo{
	
	private $idUsuario;
	private $usuario;
	private $password;
	private $correo;
	private $imagen;
	private $password_modificacion_activo;
	private $codigoVerificacion;
	private $passwordModificacion;
	private $fechaLimiteVerificacion;
	private $fechaInicio;
	private $fechaFin;
	private $fechaAlta;
	private $activo;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT u.*,NOW() AS hoy
				FROM usuario u
				WHERE 1
				$this->idUsuario
				$this->codigoVerificacion
				$this->correo
				$this->usuario
				$this->activo
				";
		return $res = $this->conexion->mostrarSQL($sql);
	}

	public function usuarioNuevo(){
		$sql = "INSERT INTO usuario(usuario,password,correo,imagen,fecha_alta,activo)
				VALUES('$this->usuario','$this->password','$this->correo','',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function activarCodigoVerificacion(){
		$sql = "UPDATE usuario 
				SET password_modificacion_activo = 1, codigo_verificacion = '$this->codigoVerificacion', fecha_limite_verificacion = '$this->fechaLimiteVerificacion'
				WHERE correo = '$this->correo' AND activo = 1 ";
		return $this->conexion->ejecutarSQL($sql);
	}

	public function cambiarPassword(){
		$sql = "UPDATE usuario 
				SET password_modificacion = '$this->passwordModificacion'
				WHERE correo = '$this->correo' AND activo = 1 ";
		return $this->conexion->ejecutarSQL($sql);
	}


    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
