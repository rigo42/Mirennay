<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminSubCategoriaModelo{

	private $idSubCategoria;
	private $idCategoria;
	private $subCategoria;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT sc.*,c.*,DATE_FORMAT(sc.fecha_alta, '%e %M, %Y') AS fechaAlta,sc.activo AS subCategoriaActivo
				FROM sub_categoria sc
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				WHERE 1 
				$this->idSubCategoria
				ORDER BY sc.sub_categoria ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT sc.*,c.*,DATE_FORMAT(sc.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM sub_categoria sc
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				WHERE 1 AND c.activo = 1
				$this->search
				$this->activo
				ORDER BY sc.sub_categoria ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO sub_categoria (id_categoria,sub_categoria,fecha_alta,activo)
				VALUES($this->idCategoria,'$this->subCategoria',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE sub_categoria 
				SET id_categoria = $this->idCategoria, sub_categoria = '$this->subCategoria',activo = $this->activo
				WHERE id_sub_categoria = $this->idSubCategoria";
		$this->conexion->ejecutarSQL($sql);
	}

	public function selectCategoria(){
		$sql = "SELECT c.*
				FROM categoria c
				WHERE c.activo = 1 
				ORDER BY c.categoria ASC
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
