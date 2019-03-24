<?php
require_once 'Conexion.php';

class TiendaModelo extends Conexion {

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
	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	//SIRVE: Para cuantos productos se mostraran, respetando los filtros que el usuario seleccione
	//PORQUE: Es necesario saber cuantos productos seran, para enviar la respuesta de cuantos a la funcion tiendaPaginadorEnlistar()
	public function tiendaPaginadorEnlistarRowCount($searchSQL,$idCategoria,$idGeneroSQL,$precioSQL,$idSubCategoriaSQL){
		$sql = "SELECT p.*,sc.*,g.* 
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				WHERE 1 AND p.activo = 1
				".$idCategoria."
				".$idGeneroSQL."
				".$precioSQL."
				".$idSubCategoriaSQL."
				".$searchSQL."
				";
		return $res = $this->rowSQL($sql);
	}


	//SIRVE: Para mostrar los productos paginados, y tambien respetando los filtros que el usuario seleccione
	//PORQUE: Cuando el programa no cabe en la memoria ram, los programas que ocupan la ram.
	public function tiendaPaginadorEnlistar($searchSQL,$idCategoria,$idGeneroSQL,$precioSQL,$idSubCategoriaSQL,$limiteSQL,$cantidadPagina){
		$sql = "SELECT p.*,sc.*,g.*,NOW() AS 'hoy',p.fecha_alta AS 'fechaAltaProducto' 
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				WHERE 1 AND p.activo = 1
				".$idCategoria."
				".$idGeneroSQL."
				".$precioSQL."
				".$idSubCategoriaSQL."
				".$searchSQL."
				LIMIT ".$limiteSQL." , ".$cantidadPagina." ";
		$res = $this->conexion->mostrarSQL($sql);
		$row = $res->rowCount();
		if($row > 0){
			return $res;
		}else{
			return false;
		}
		
	}

	//SIRVE: Para mostrar las categorias que existen, pero solo los que estan relacionados con los productos y que estan activos
	//PORQUE: De nada sirve mostrar todos las sub categorias, si no habran productos de esta misma sub categoria
	public function mostrarSubCategoria(){
		$sql = "SELECT sc.*,count(p.id_producto) as 'cuantos'
				FROM sub_categoria sc
				INNER JOIN producto p ON p.id_sub_categoria = sc.id_sub_categoria
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				WHERE sc.activo = 1 and c.activo = 1 AND p.activo = 1 
				GROUP BY sc.sub_categoria";
		return $res = $this->conexion->mostrarSQL($sql);
	}	

	//SIRVE: Para mostrar los generos que existen, pero solo los que estan relacionados con los productos y que estan activos
	//PORQUE: De nada sirve mostrar todos los generos, si no habran productos de este mismo genero
	public function mostrarGenero(){
		$sql = "SELECT DISTINCT g.*
				FROM producto_genero g
				INNER JOIN producto p ON p.id_genero = g.id_genero
				WHERE g.activo = 1 AND p.activo = 1 
				ORDER BY g.genero";
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