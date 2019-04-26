<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminPuntoVentaModelo{

	private $codigo;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT p.*,pd.*,t.*
				FROM producto p 
				INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto 
				INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
				WHERE p.activo = 1 AND pd.activo = 1 $this->codigo ";
		return $this->conexion->mostrarSQL($sql);
	}

	public function confirmarPago(){
		//Insertar pedido
		
		$idEmpleado = $_SESSION['idEmpleado'];
		$datos = $_SESSION['carritoFisico'];
		$idEmpleado = $_SESSION['idEmpleado'];
		$sql = "INSERT INTO venta_fisica(id_producto_detalle ,id_empleado,cantidad,subtotal,folio,fecha_alta,activo) VALUES ";
		$folio = $this->folio_fisico();
		for ($i=0; $i < count($datos) ; $i++) { 

			$sql .= "( '".$datos[$i]['idProductoDetalle']."','".$idEmpleado."','".$datos[$i]['cantidadPedido']."','".$datos[$i]['subTotal']."','".$folio."',NOW(),1)";
			if($i == count($datos)-1){
				$sql .= ";"; // si es que se llega al final, termina la consulta
			}else{
				$sql .= ", "; // sino se pone una , y se continua.
			}
		}
		$this->conexion->ejecutarSQL($sql);

		//Actualizar producto de cantidad existencial
		for ($i=0; $i < count($datos) ; $i++) { 
			$sqlUpdate = "UPDATE producto_detalle SET cantidad = cantidad - ".$datos[$i]['cantidadPedido']." WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
			$this->conexion->ejecutarSQL($sqlUpdate);

			$sqlCantidad = "SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = ".$datos[$i]['idProductoDetalle'];
			$resCantidad = $this->conexion->mostrarSQL($sqlCantidad);

			foreach ($resCantidad as $keyCantidad){
				$cantidad = $keyCantidad['cantidad'];
				if($cantidad == 0){
					$sqlUpdateInactivo = "UPDATE producto_detalle SET activo = 0 WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
					$this->conexion->ejecutarSQL($sqlUpdateInactivo);
				}
			}			
		}
		unset($_SESSION['carritoFisico']);
	}

	public function folio_fisico(){
		$sql = " SELECT MAX(folio) AS 'folio' FROM venta_fisica ";
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

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
