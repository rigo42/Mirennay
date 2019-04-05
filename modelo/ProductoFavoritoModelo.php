<?php
require_once 'conexion.php';

class ProductoFavoritoModelo extends Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function productoVentanaFavorito($idUsuario){
		$sql = "SELECT SUM(pd.cantidad) AS 'sumaCantidad', pf.*,p.*,pd.* FROM producto_favorito pf
					INNER JOIN producto p ON p.id_producto = pf.id_producto
					INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
					INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
					WHERE p.activo = 1 AND pf.activo = 1  AND u.id_usuario = $idUsuario
					GROUP by p.id_producto
					ORDER BY pf.fecha_alta DESC";
		return $res = $this->conexion->mostrarSQL($sql);
	}

	public function productoFavorito($idProducto,$idUsuario){
		$sqlValidacion = "SELECT * FROM producto_favorito WHERE id_producto = $idProducto AND id_usuario = $idUsuario ";
		$resValidacion = $this->conexion->mostrarSQL($sqlValidacion);
		$rowValidacion = $resValidacion->rowCount();
		if($rowValidacion > 0){
			foreach ($resValidacion as $keyValidacion) {
				$activo = $keyValidacion['activo'];
			}
			if($activo == 1){
				$activo = 0;
			}else{
				$activo = 1;
			}
			$sql = "UPDATE producto_favorito SET  activo = $activo
					WHERE id_producto = $idProducto AND id_usuario = $idUsuario ";
			$this->conexion->ejecutarSQL($sql);
		}else{
			$sql = "INSERT INTO producto_favorito(id_producto,id_usuario,fecha_alta,activo)
				    VALUES($idProducto,$idUsuario,NOW(),1)";
			$this->conexion->ejecutarSQL($sql);
		}
	}

	public function productoFavoritoComprobar($idProducto,$idUsuario){
		$sql = "SELECT pf.activo AS 'comprobarActivo' 
				FROM producto_favorito pf
				INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
				INNER JOIN producto p ON p.id_producto = pf.id_producto
				WHERE p.id_producto = $idProducto AND u.id_usuario = $idUsuario";
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