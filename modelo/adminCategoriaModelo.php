<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminCategoriaModelo{

	private $idCategoria;
	private $categoria;
	private $imagen;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT c.*,DATE_FORMAT(c.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM categoria c
				WHERE 1 
				$this->idCategoria
				ORDER BY c.categoria ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT c.*,DATE_FORMAT(c.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM categoria c
				WHERE 1 
				$this->search
				$this->activo
				ORDER BY c.categoria ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO categoria (categoria,imagen_principal,fecha_alta,activo)
				VALUES('$this->categoria','$this->imagen',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE categoria 
				SET categoria = '$this->categoria', imagen_principal = '$this->imagen',activo = $this->activo
				WHERE id_categoria = $this->idCategoria";
		$this->conexion->ejecutarSQL($sql);
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
