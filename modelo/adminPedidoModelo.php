<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminPedidoModelo{

	private $folio;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function mostrarPedidoGeneral(){
		$sql = "SELECT pu.id_pedido_usuario,ud.nombre_completo,u.usuario,pu.folio,u.imagen,
                       DATE_FORMAT(pu.fecha_alta, '%e %M, %Y') AS fecha_alta
				FROM pedido_usuario pu 
				LEFT JOIN venta_online vo ON vo.id_pedido_usuario = pu.id_pedido_usuario 
				INNER JOIN usuario_detalle ud ON ud.id_usuario_detalle = pu.id_usuario_detalle 
				INNER JOIN usuario u ON u.id_usuario = ud.id_usuario 
				WHERE 1 $this->folio AND ud.activo = 1 AND u.activo = 1 AND vo.id_pedido_usuario IS NULL 
                GROUP BY pu.folio
                ORDER BY pu.id_pedido_usuario DESC";
        return $this->conexion->mostrarSQL($sql);
    }

     public function mostrarPedidoDetalle($folio){
        $sql = "SELECT pd.*,p.*,pu.*,t.*
				FROM producto_detalle pd 
				INNER JOIN producto p ON p.id_producto = pd.id_producto
				INNER JOIN pedido_usuario pu ON pu.id_producto_detalle = pd.id_producto_detalle
				INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
				WHERE pu.activo = 1 AND pu.folio = '$folio'";
        return $this->conexion->mostrarSQL($sql);
    }

    public function modalDireccion($folio){
    	$sql = "SELECT ud.*,m.*
    			FROM usuario_detalle ud 
    			INNER JOIN pedido_usuario pu ON pu.id_usuario_detalle = ud.id_usuario_detalle 
				INNER JOIN municipio m ON m.id_municipio = ud.id_municipio
    			WHERE pu.folio = '$folio' AND ud.activo = 1 AND pu.activo = 1
    			GROUP BY ud.id_usuario_detalle";
        return $this->conexion->mostrarSQL($sql);
    }

    public function obtenerPedido($folio){
        $sql = "SELECT pu.id_pedido_usuario
        		FROM pedido_usuario pu 
    			WHERE pu.folio = '$folio' AND pu.activo = 1";
        return $this->conexion->mostrarSQL($sql);
    }

    public function insertarVentaOnline($idPedidoUsuario){
    	$sql = "INSERT INTO venta_online (id_pedido_usuario,fecha_alta,activo)
    			VALUES($idPedidoUsuario,NOW(),1)";
    	$this->conexion->ejecutarSQL($sql);
    }

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}

}
?>
