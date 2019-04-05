<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class GeneroModelo{
	
	private $idGenero;
	private $genero;
	private $fechaAlta;
	private $activo;
	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function construir($sql){
		$res = $this->conexion->mostrarSQL($sql);
		$row = $this->row($res);
		if($row > 0){
			foreach ($res as $key) {
				$this->idGenero = $key['id_genero'];
				$this->genero = $key['genero'];
				$this->fechaAlta = $key['fecha_alta'];
				$this->activo = $key['activo'];
			}
		}else{
			return false;
		}
	}

	public function mostrar($sql){
		return $this->conexion->mostrarSQL($sql);
	}


	public function nuevo($sql){
		return $this->conexion->ejecutarSQL($sql);
	}

	public function editar($sql){
		return $this->conexion->ejecutarSQL($sql);
	}

	public function eliminar($sql){
		return $this->conexion->ejecutarSQL($sql);
	}

	public function row($sql){
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
