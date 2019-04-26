<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminCategoriaModelo{

	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function coleccion(){
		$sql = "SELECT c.* 
				FROM categoria c
				INNER JOIN sub_categoria sc ON sc.id_categoria = c.id_categoria
				INNER JOIN producto p ON p.id_sub_categoria = sc.id_sub_categoria
				WHERE c.activo = 1 AND sc.activo = 1
				GROUP BY c.id_categoria
				ORDER BY c.id_categoria DESC";
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
