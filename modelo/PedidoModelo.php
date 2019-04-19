<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class pedidoModelo{

	private $folio;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function insertarPedido($idUsuarioDetalle){
		//Insertar pedido
		$carrito = $_SESSION['carrito'];
		$sql = "INSERT INTO pedido_usuario(id_producto_detalle ,id_usuario_detalle ,cantidad,subtotal,folio,fecha_alta,activo) VALUES ";
		$folio = $this->folio_online();
		for ($i=0; $i < count($carrito) ; $i++) { 
		 	$subTotal = 0;
		 	$subTotal = $carrito[$i]['precio'] * $carrito[$i]['idProductoDetalleCantidad'];

			$sql .= "( '".$carrito[$i]['idProductoDetalle']."','".$idUsuarioDetalle."','".$carrito[$i]['idProductoDetalleCantidad']."','".$subTotal."','".$folio."',NOW(),1)";
			if($i == count($carrito)-1){
				$sql .= ";"; // si es que se llega al final, termina la consulta
			}else{
				$sql .= ", "; // sino se pone una , y se continua.
			}
		}
		$this->conexion->ejecutarSQL($sql);

		//Actualizar producto de cantidad existencial
		for ($i=0; $i < count($carrito) ; $i++) { 
			$sqlUpdate = "UPDATE producto_detalle SET cantidad = cantidad - ".$carrito[$i]['idProductoDetalleCantidad']." WHERE id_producto_detalle =  ".$carrito[$i]['idProductoDetalle']." ";
			$this->conexion->ejecutarSQL($sqlUpdate);

			$sqlCantidad = "SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = ".$carrito[$i]['idProductoDetalle'];
			$resCantidad = $this->conexion->mostrarSQL($sqlCantidad);

			foreach ($resCantidad as $keyCantidad){
				$cantidad = $keyCantidad['cantidad'];
				if($cantidad == 0){
					$sqlUpdateInactivo = "UPDATE producto_detalle SET activo = 0 WHERE id_producto_detalle =  ".$carrito[$i]['idProductoDetalle']." ";
					$this->conexion->ejecutarSQL($sqlUpdateInactivo);
				}
			}			
		}
		unset($_SESSION['carrito']);
	}

	public function folio_online(){
		$sql = " SELECT MAX(folio) AS 'folio' FROM pedido_usuario ";
		$res = $this->conexion->mostrarSQL($sql);
 		foreach ($res as $key) {
 			if($key['folio'] == null){
 				$folio = "MIRENNAY0000000001";	
 			}else{
 				$folio = ++$key['folio'];
 			}
 		}
	 	return $folio;
	}

	public function estado(){
        $sql = "SELECT * FROM estado";
        return $this->conexion->mostrarSQL($sql);
    }

    public function municipio($idEstado){
        $sql = "SELECT * FROM municipio WHERE id_estado = $idEstado";
        return $this->conexion->mostrarSQL($sql);
    }

	/////////////////////////////////////
    //            ADMIN                \\
   //////////////////////////////////////

	public function mostrarPedidoGeneral(){
		$sql = "SELECT pu.id_pedido_usuario,ud.nombre_completo,u.usuario,pu.folio 
				FROM pedido_usuario pu 
				LEFT JOIN venta_online vo ON vo.id_pedido_usuario = pu.id_pedido_usuario 
				INNER JOIN usuario_detalle ud ON ud.id_usuario_detalle = pu.id_usuario_detalle 
				INNER JOIN usuario u ON u.id_usuario = ud.id_usuario 
				WHERE 1 $this->folio AND ud.activo = 1 AND u.activo = 1 AND vo.id_pedido_usuario IS NULL GROUP BY pu.folio";
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
