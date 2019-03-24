<?php
require_once 'Conexion.php';

class ProductoEstrellaModelo extends Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function productoEstrella($idProducto){
		$sql = "SELECT COUNT(id_producto_comentario) AS 'cantidadEstrella',
					   SUM(cantidad_estrella) AS 'sumaEstrella'
				FROM producto_comentario
			 	WHERE activo = 1 AND id_producto = $idProducto";
		return $res = $this->conexion->mostrarSQL($sql);
	}

	public function ventanaEncuestaEstrellaEscalera($i,$idProducto){
		$sql = "SELECT COUNT(id_producto_comentario) AS 'cantidadEstrella'
				FROM producto_comentario
				WHERE activo = 1 AND cantidad_estrella = $i AND id_producto = $idProducto";
     	return $this->conexion->mostrarSQL($sql);
	}

	public function ventanaEncuestaComentarioRowCount($idProducto){
		$sql = "SELECT p.*,pc.*,u.*
				FROM producto_comentario pc
		        INNER JOIN producto p ON pc.id_producto = p.id_producto
		        INNER JOIN usuario u ON u.id_usuario = pc.id_usuario
		        WHERE p.activo = 1 AND pc.activo = 1 AND u.activo =1 AND pc.id_producto = $idProducto ";
		return $res = $this->rowSQL($sql);
	}

	public function ventanaEncuestaComentarioEnlistar($idProducto,$limite,$cantidadPagina){
		$sql = "SELECT p.*,pc.*,u.*, u.fecha_alta AS 'fecha_comentario' FROM producto_comentario pc
				INNER JOIN producto p ON pc.id_producto = p.id_producto
				INNER JOIN usuario u ON u.id_usuario = pc.id_usuario
				WHERE 1 AND p.activo = 1 AND pc.activo = 1 AND u.activo = 1 AND pc.id_producto = ".$idProducto."  
				ORDER BY pc.id_producto_comentario DESC
				LIMIT ".$limite." , ".$cantidadPagina." ";
		$res = $this->conexion->mostrarSQL($sql);
		$row = $res->rowCount();
		if($row > 0){
			return $res;
		}else{
			return false;
		}
	}

	public function insertarEncuestaFormulario($idUsuario,$idProducto,$comentario,$cantidadEstrella){
		$sql = "INSERT INTO producto_comentario(id_producto,id_usuario,comentario,cantidad_estrella,fecha_alta,activo) 
					VALUES($idProducto,$idUsuario,'$comentario',$cantidadEstrella,NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
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