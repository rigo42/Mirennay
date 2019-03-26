<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'Conexion.php';

class ProductoModelo{
	
	//Atributos propios del producto
	private $idProducto;
	private $idSubCategoria;
	private $genero;
	private $producto;
	private $descripcion;
	private $observacion;
	private $precio;
	private $imagenPrincipal;
	private $activoOferta;
	private $titulo;
	private $subTitulo;
	private $fechaFinOferta;
	private $imagenOferta;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function construir(){
		
	}

	public function mostrar(){
		$sql = "SELECT p.*,sc.*,g.* 
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				WHERE 1 
				".$this->search."
				".$this->activo."
				";
		return $this->conexion->mostrarSQL($sql);
	}


	public function nuevo(){
		return $this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		return $this->conexion->ejecutarSQL($sql);
	}

	public function eliminar(){
		return $this->conexion->ejecutarSQL($sql);
	}

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
