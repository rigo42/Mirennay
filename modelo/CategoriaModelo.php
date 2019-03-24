<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'Conexion.php';

class CategoriaModelo{

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function coleccion(){
		$sql = "SELECT * FROM categoria WHERE activo = 1";
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
