<?php 
	/**
	 * Autor Rigoberto Villa Rodríguez
	 */

	require_once 'conexion.php';

	class SubCategoriaModelo{
		
		private $idSubCategoria;
		private $idCategoria;
		private $subCategoria;
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
					$this->idSubCategoria = $key['id_sub_categoria'];
					$this->idCategoria = $key['id_categoria'];
					$this->subCategoria = $key['sub_categoria'];
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