<?php
require_once 'conexion.php';

class productoDetalleModelo{

	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function producto($idProducto){
		$sql = "SELECT p.*,c.*,sc.*,p.imagen_principal AS 'imagenPrincipalProducto'
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				WHERE p.activo = 1  AND c.activo = 1 AND p.id_producto = $idProducto AND sc.activo = 1";
		return $this->conexion->mostrarSQL($sql);
	}

	public function productoDetalle($idProducto){
		$sql = "SELECT pd.*,t.*
				FROM producto_detalle pd
				INNER JOIN producto p ON p.id_producto = pd.id_producto
				INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
				WHERE p.activo = 1 AND t.activo = 1 AND p.id_producto = $idProducto ";
		return $this->conexion->mostrarSQL($sql);
	}

	public function comentarioRow($idProducto){
		$sql = "SELECT COUNT(id_producto_comentario) AS 'comentarioRow'
     			FROM producto_comentario
     			WHERE activo = 1 AND id_producto = $idProducto";
		return $this->conexion->mostrarSQL($sql);
	}

	public function selectIdProductoDetalleCantidad($idProductoDetalle){
		$sql = "SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = $idProductoDetalle";
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