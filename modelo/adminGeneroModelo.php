<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminGeneroModelo{

	private $idGenero;
	private $genero;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT g.*,DATE_FORMAT(g.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM producto_genero g
				WHERE 1 
				$this->idGenero
				ORDER BY g.genero ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT g.*,DATE_FORMAT(g.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM producto_genero g
				WHERE 1 
				$this->search
				$this->activo
				ORDER BY g.genero ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO producto_genero (genero,fecha_alta,activo)
				VALUES('$this->genero',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE producto_genero 
				SET genero = '$this->genero',activo = $this->activo
				WHERE id_genero = $this->idGenero";
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
