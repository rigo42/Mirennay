<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminTallaModelo{

	private $idTalla;
	private $talla;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT t.*,DATE_FORMAT(t.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM producto_talla t
				WHERE 1 
				$this->idTalla
				ORDER BY t.talla ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT t.*,DATE_FORMAT(t.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM producto_talla t
				WHERE 1 
				$this->search
				$this->activo
				ORDER BY t.talla ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO producto_talla (talla,fecha_alta,activo)
				VALUES('$this->talla',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE producto_talla 
				SET talla = '$this->talla',activo = $this->activo
				WHERE id_talla = $this->idTalla";
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
