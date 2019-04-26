<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminLoginModelo{
	
	private $idEmpleado;
	private $rol;
	private $empleado;
	private $nombre;
	private $apellidoPaterno;
	private $apellidoMaterno;
	private $nss;
	private $salario;
	private $password;
	private $correo;
	private $passwordModificacionActivo;
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
		$sql = "SELECT e.*,r.*,NOW() AS 'hoy'
				FROM empleado e
				INNER JOIN rol r ON r.id_rol = e.id_rol
				WHERE 1 
				$this->empleado
				$this->idEmpleado
				$this->correo
				$this->codigoVerificacion
				$this->activo
				";
		return $this->conexion->mostrarSQL($sql);
	}
	
	public function activarCodigoVerificacion(){
		$sql = "UPDATE empleado 
				SET password_modificacion_activo = 1, codigo_verificacion = '$this->codigoVerificacion', fecha_limite_verificacion = '$this->fechaLimiteVerificacion'
				WHERE correo = '$this->correo' AND activo = 1 ";
		return $this->conexion->ejecutarSQL($sql);
	}

	public function cambiarPassword(){
		echo $sql = "UPDATE empleado 
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
