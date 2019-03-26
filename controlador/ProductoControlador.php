<?php 
	//imports
	require_once 'modelo/ProductoModelo.php';

	class ProductoControlador{

		private $productoModelo; 
		
		function __construct(){
			$this->productoModelo = new ProductoModelo();
		}

		//SIRVE: Para mostrar la tienda
		//PORQUE: Porque es mejor tener todo esto bien separado. y llamarlo cuando haga falta
		public function index(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/producto/index.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		//SIRVE: Para mostrar la tienda
		//PORQUE: Porque es mejor tener todo esto bien separado. y llamarlo cuando haga falta
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/menu/index.php');

		    	include('vista/admin/producto/productoNuevo.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		//SIRVE: Para mostrar la tienda
		//PORQUE: Porque es mejor tener todo esto bien separado. y llamarlo cuando haga falta
		public function editar(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/menu/index.php');

				if(isset($_GET['idProducto'])){
		    		include('vista/admin/producto/productoEditar.php');
				}else{
			    	echo "Por favor envie el identificador del producto";
				}

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		//SIRVE:
		//PORQUE:
		public function producto(){
			if($_POST){
				$searchSQL = "";
				if($_POST['search'] != ""){
					$search = htmlspecialchars(addslashes($_POST['search']));
					$searchSQL = " AND  (p.producto like '%" .$search. "%') ";
					$this->productoModelo->set("search",$searchSQL);
				}
				$activoSQL = "";
				if($_POST['activo'] != ""){
					$activo = htmlspecialchars(addslashes($_POST['activo']));
					$activoSQL = " AND  p.activo = $activo ";
					$this->productoModelo->set("activo",$activoSQL);
				}
				$res = $this->productoModelo->mostrar();
				include('vista/admin/producto/producto.php');
			}
		}

	}
 ?>