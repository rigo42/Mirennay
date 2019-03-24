<?php
require_once 'Conexion.php';

class ProductoCarritoModelo extends Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function funcion(){
		$sql = "";
		return $res = $this->conexion->mostrarSQL($sql);
	}

	//SIRVE: Para mostrar cuantos resultados obtuvo la consulta.
	//PORQUE: toda clase tendra ese metodo para agilizar codigo
	public function rowSQL($sql){
		return $this->conexion->rowSQL($sql);
	}

	public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}

}
?>