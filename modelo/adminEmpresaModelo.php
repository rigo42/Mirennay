<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminEmpresaModelo{
	
	//Atributos propios del producto
	private $idEmpresa;
	private $empresa;
	private $direccion;
	private $celular;
	private $correo;
	private $observacion;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT e.*
				FROM empresa e
				WHERE 1
				".$this->idEmpresa."
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT e.*
				FROM empresa e
				WHERE 1 
				".$this->search."
				".$this->activo."
				ORDER BY e.id_empresa DESC
				LIMIT 1000
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO empresa (empresa,direccion,celular,correo,observacion,fecha_alta,activo) VALUES('$this->empresa','$this->direccion','$this->celular','$this->correo','$this->observacion',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE empresa SET empresa = '$this->empresa',direccion = '$this->direccion',celular = '$this->celular',correo = '$this->correo',observacion = '$this->observacion',activo = $this->activo WHERE id_empresa = $this->idEmpresa";
		$this->conexion->ejecutarSQL($sql);
	}

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
