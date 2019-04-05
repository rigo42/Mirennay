<?php
require_once 'conexion.php';

class ProductoNuevoModelo extends Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function productoNuevo(){

		$sql = "SELECT p.*,sc.*,NOW() AS 'hoy', p.fecha_alta AS 'fechaAltaProducto' 
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria 
				WHERE sc.activo = 1 AND p.activo = 1 AND p.fecha_alta >= adddate(NOW(),interval -90 day)";
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