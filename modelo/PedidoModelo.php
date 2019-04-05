<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class PedidoModelo{

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function insertarPedido($idUsuarioDetalle){
		//Insertar pedido
		$carrito = $_SESSION['carrito'];
		$sql = "INSERT INTO pedido_usuario(id_producto_detalle ,id_usuario_detalle ,cantidad,subtotal,folio,fecha_pedido,entregado,activo) VALUES ";
		$folio = $this->folio();
		for ($i=0; $i < count($carrito) ; $i++) { 
		 	$subTotal = 0;
		 	$subTotal = $carrito[$i]['precio'] * $carrito[$i]['idProductoDetalleCantidad'];

			$sql .= "( '".$carrito[$i]['idProductoDetalle']."','".$idUsuarioDetalle."','".$carrito[$i]['idProductoDetalleCantidad']."','".$subTotal."','".$folio."',NOW(),0,1)";
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

	public function folio(){
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

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
