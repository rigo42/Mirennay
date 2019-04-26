<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminEmpleadoModelo{

	private $idEmpleado;
	private $idRol;
	private $empleado;
	private $nombre;
	private $apellidoPaterno;
	private $apellidoMaterno;
	private $nss;
	private $salario;
	private $password;
	private $correo;
	private $celular;
	private $passwordModificacionActivo;
	private $codigoVerificacion;
	private $passwordModificacion;
	private $fechaLimiteVerificacion;
	private $fechaInicio;
	private $fechaFin;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT e.*,r.*,CONCAT(e.nombre, ' ', e.apellido_paterno, ' ', e.apellido_materno) AS nombre_completo,
					   DATE_FORMAT(e.fecha_alta, '%e %M, %Y') AS fecha_alta,e.activo AS empleadoActivo
				FROM empleado e
				INNER JOIN rol r ON r.id_rol = e.id_rol
				WHERE 1 
				$this->idEmpleado
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT e.*,r.*,CONCAT(e.nombre, ' ', e.apellido_paterno, ' ', e.apellido_materno) AS nombre_completo,
					   DATE_FORMAT(e.fecha_alta, '%e %M, %Y') AS fecha_alta
				FROM empleado e
				INNER JOIN rol r ON r.id_rol = e.id_rol
				WHERE 1 
				$this->search
				$this->activo
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO empleado (id_rol,empleado,nombre,apellido_paterno,apellido_materno,nss,salario,password,correo,celular,fecha_alta,activo)
				VALUES($this->idRol,'$this->empleado','$this->nombre','$this->apellidoPaterno','$this->apellidoMaterno','$this->nss','$this->salario','$this->password','$this->correo','$this->celular',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE empleado 
				SET id_rol = $this->idRol, nombre = '$this->nombre',apellido_paterno = '$this->apellidoPaterno',apellido_materno = '$this->apellidoMaterno',nss = '$this->nss', salario = '$this->salario',correo = '$this->correo',celular = '$this->celular',activo = $this->activo
				WHERE id_empleado = $this->idEmpleado";
		$this->conexion->ejecutarSQL($sql);
	}

	public function generarMatricula(){
		$sql = "SELECT MAX(e.empleado) AS matricula 
				FROM empleado e 
				WHERE e.activo = 1";
		$res = $this->conexion->mostrarSQL($sql);
		$row = $res->rowCount();
		$matricula = "";
		if($row > 0){
			foreach ($res as $key => $value) {}
			$matricula = ++$value['matricula'];
		}else{
			$matricula = "01-001-0001";
		}
		return $matricula;
	}

	public function selectRol(){
		$sql = "SELECT r.*
				FROM rol r 
				WHERE r.activo = 1 AND r.rol != 'cliente'
				";
		return $this->conexion->mostrarSQL($sql);
	}

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
