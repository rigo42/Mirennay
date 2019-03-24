<?php 
	//Imports
	require_once 'modelo/ProductoCarritoModelo.php';

	class ProductoCarritoControlador{
		
		private $productoCarritoModelo;

		//SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
		//PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
		public function __construct(){
			//$this->productoCarritoModelo =  new ProductoCarritoModelo;
		}  

		public function productoVentanaCarrito(){
			session_start();
	        if(isset($_SESSION['idUsuario'])){
	        	if(isset($_SESSION['carrito'])){
	        		include('vista/cliente/header/ventanaCarrito.php');
	        	}else{
	        		echo "Actualmente no tiene nada en el carrito";
	        	}
	        }else{
	            echo "Necesitas iniciar sesión para guardar en el carrito";
	        }
		}

		public function productoCarritoComprobar($idProducto){
			//session_start();
			$validarProductoCarrito = "";
			if(isset($_SESSION['idUsuario'])){
				if(isset($_SESSION['carrito'])){
					$datos = $_SESSION['carrito'];
					
					for ($i=0; $i < count($datos); $i++) { 
						if($datos[$i]['idProducto'] == $idProducto){
							$validarProductoCarrito = 1; //true
						}
					}
					if($validarProductoCarrito == 1){
						return 1; //true
					}else{
						return 2; //false
					}
				}else{
					return $validarProductoCarrito = 2; //false
				}
			}else{
				return $validarProductoCarrito = 3; //Nesecita iniciar sesión
			}
		}

		public function addProductoCarrito(){
			if(!isset($_SESSION['idUsuario'])){
				session_start();
			}
			
			if(isset($_SESSION['idUsuario'])){

				if($_POST){
					
					$idProducto = htmlspecialchars(addslashes(urldecode(openssl_decrypt($_POST['idProducto'], COD, KEY))));
					$idProductoDetalle = htmlspecialchars(addslashes(openssl_decrypt($_POST['idProductoDetalle'], COD, KEY)));
					$idProductoDetalleCantidad = htmlspecialchars(addslashes($_POST['idProductoDetalleCantidad']));
					$producto = htmlspecialchars(addslashes($_POST['producto']));
					$precio = htmlspecialchars(addslashes($_POST['precio']));
					$imagenPrincipal = htmlspecialchars(addslashes($_POST['imagenPrincipal']));
					$talla = htmlspecialchars(addslashes($_POST['talla']));
					$color = htmlspecialchars(addslashes($_POST['color']));

					if(isset($_SESSION['carrito'])){

						$datos=$_SESSION['carrito'];

						//Posicion del arreglo donde se solicitara cambiar la cantidad del producto
						$posicionCambiarCantidad = 0;
						//Si es false: "No habra cambio de cantidad" caso contrario, si
						$encontroCambiarCantidad = false;
						//Si es false: "No habra producto nuevo", caso contario, si
						$insertarNuevo=true;

						for($i=0;$i<count($datos);$i++){
							if($datos[$i]['idProductoDetalle'] == $idProductoDetalle && $datos[$i]['idProductoDetalleCantidad'] != $idProductoDetalleCantidad){
								$encontroCambiarCantidad = true;
								$posicionCambiarCantidad = $i;

							}if($datos[$i]['idProductoDetalle'] == $idProductoDetalle){
								$insertarNuevo = false;
							}
						}
						if($encontroCambiarCantidad == true){
							$datos[$posicionCambiarCantidad]['idProductoDetalleCantidad'] = $idProductoDetalleCantidad;
							$_SESSION['carrito']=$datos;

						}
						if($insertarNuevo == true){
							$datosNuevos=array('idProducto'=>$idProducto,'idProductoDetalle'=>$idProductoDetalle,'idProductoDetalleCantidad'=>$idProductoDetalleCantidad,'producto'=>$producto,'precio'=>$precio,'imagenPrincipal'=>$imagenPrincipal,'talla'=>$talla,'color'=>$color);
							array_push($datos, $datosNuevos);
							$_SESSION['carrito']=$datos;
						}
					}else{
						$datos[]=array('idProducto'=>$idProducto,'idProductoDetalle'=>$idProductoDetalle,'idProductoDetalleCantidad'=>$idProductoDetalleCantidad,'producto'=>$producto,'precio'=>$precio,'imagenPrincipal'=>$imagenPrincipal,'talla'=>$talla,'color'=>$color);
						$_SESSION['carrito']=$datos;
					}
				}
			}else{
				echo 1;//Debe se iniciar sesión
			}
		}

		public function deleteProductoCarrito(){
			session_start();
			if(isset($_SESSION['idUsuario'])){
				if(isset($_SESSION['carrito'])){
					if($_POST){
						$idProductoDetalle = htmlspecialchars(addslashes(openssl_decrypt($_POST['idProductoDetalle'], COD, KEY)));
						$arreglo=$_SESSION['carrito'];
						for($i=0;$i<count($arreglo);$i++){
							if($arreglo[$i]['idProductoDetalle'] == $idProductoDetalle){
								array_splice($arreglo, $i, 1);
							}
						}
						$_SESSION['carrito']=$arreglo;
					}else{
						echo "Porfavor enviar los post";
					}
				}else{
					echo "No existe la sesión carrito";
				}
			}else{
				echo "Porfavor inicie sesion ProductoCarritoControlador";
			}
		}

	}
 ?>

 