<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class empresaModelo{
	
	//Atributos propios del producto
	private $id_empresa;
	private $empresa;
	private $direccion;
	private $celular;
	private $observacion;
	private $fecha_alta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT
				FROM 
				WHERE 1
				".$this->idProducto."
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

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
