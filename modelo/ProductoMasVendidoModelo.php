<?php
require_once 'Conexion.php';

class ProductoMasVendidoModelo extends Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function productoMasVendido(){

		$sql = "SELECT p.*, SUM(pu.cantidad) AS 'TotalVentas', sc.* ,p.fecha_alta AS 'fechaAltaProducto',
				NOW() AS 'hoy'
				FROM pedido_usuario pu
				INNER JOIN producto_detalle pd ON pd.id_producto_detalle = pu.id_producto_detalle 
				INNER JOIN producto p ON p.id_producto = pd.id_producto
                INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
                WHERE p.activo = 1 AND sc.activo = 1 AND c.activo = 1
				GROUP BY p.id_producto 
				ORDER BY SUM(pu.cantidad) DESC 
				LIMIT 0 , 30";
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