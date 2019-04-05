<?php 
	//Imports
	require_once 'modelo/productoDetalleModelo.php';
	require_once 'controlador/productoFavoritoControlador.php';
	require_once 'controlador/productoEstrellaControlador.php';
	require_once 'controlador/productoCarritoControlador.php';

	class ProductoDetalleControlador{
		
		private $productoDetalleModelo;
		private $productoFavoritoControlador; 
		private $productoEstrellaControlador;
		private $productoCarritoControlador;

		//SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
		//PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
		public function __construct(){
			$this->productoDetalleModelo =  new ProductoDetalleModelo;
			$this->productoFavoritoControlador = new ProductoFavoritoControlador();
			$this->productoEstrellaControlador = new ProductoEstrellaControlador();
			$this->productoCarritoControlador = new ProductoCarritoControlador();
		} 

		public function index(){
			session_start();
			include('vista/cliente/head/index.php');
	        include('vista/cliente/header/index.php');
			include('vista/cliente/menu/index.php');
	    	if(isset($_GET['idProducto'])){
	    		include('vista/cliente/productoDetalle/index.php');
			}else{
		    	echo "Por favor envie el identificador del producto";
			}
	    	include('vista/cliente/contacto/index.php');
	    	include('vista/cliente/footer/index.php');
		}

		public function producto($idProducto){
			return $this->productoDetalleModelo->producto($idProducto);
		}

		//SIRVE: Para mostrar los resultados del detalle de este producto (id)
		//PORQUE: Son necesarios para la talla y el color y las imagenes
		public function productoDetalle($idProducto){
			return $this->productoDetalleModelo->productoDetalle($idProducto);
		}

		//SIRVE: Para mostrar cuantas personas an comentado este producto (id)
		//PORQUE: Seria interesante ver cuantas personas an comentado
		public function comentarioRow($idProducto){
			$res = $this->productoDetalleModelo->comentarioRow($idProducto);
			foreach ($res as $key) {
				$comentarioRow = $key['comentarioRow'];
			}
			return $comentarioRow;
		}

		public function selectIdProductoDetalleCantidad(){
			if(isset($_POST['idProductoDetalle'])){
				$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'], COD, KEY);
				$res = $this->productoDetalleModelo->selectIdProductoDetalleCantidad($idProductoDetalle);
				foreach ($res as $key) {
					$cantidad = $key['cantidad'];
				}
				include('vista/cliente/productoDetalle/selectIdProductoDetalleCantidad.php');
			}else{
				echo "No cambie el codigo o sera baneado de esta pagina";
			}
		}
		
	}
 ?>

 