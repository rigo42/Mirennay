<?php 
	//imports
	require_once 'modelo/almacenModelo.php';

	class AlmacenControlador{

		private $almacenModelo; 
		
		function __construct(){
			$this->almacenModelo = new AlmacenModelo();
		}

		//SIRVE: 
		//PORQUE: 
		public function index(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/producto/index.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		//SIRVE: 
		//PORQUE: 
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/producto/nuevo.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		//SIRVE: 
		//PORQUE: 
		public function editar(){
			session_start();
			if(isset($_SESSION['idUsuario']) && $_SESSION['rol'] == "admin"){

				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				if(isset($_GET['idProducto'])){
		    		include('vista/admin/producto/editar.php');
				}else{
			    	echo "Por favor envie el identificador del producto";
				}

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."incio");
			}
		}

		public function construir(){
			return $this->almacenModelo->construir();
		}

		//SIRVE:
		//PORQUE:
		public function producto(){
			if($_POST){
				$searchSQL = "";
				if($_POST['search'] != ""){
					$search = htmlspecialchars(addslashes($_POST['search']));
					$searchSQL = " AND  (p.producto like '%" .$search. "%') ";
					$this->almacenModelo->set("search",$searchSQL);
				}
				$activoSQL = "";
				if($_POST['activo'] != ""){
					$activo = htmlspecialchars(addslashes($_POST['activo']));
					$activoSQL = " AND  p.activo = $activo ";
					$this->almacenModelo->set("activo",$activoSQL);
				}
				$res = $this->almacenModelo->mostrar();
				include('vista/admin/producto/producto.php');
			}
		}

		public function productoNuevo(){
			if($_POST){

                $ruta = "libreria/imgProducto/";
                $rutaOferta = "libreria/imgProductoOferta/";

				$cantidadColor = htmlspecialchars(addslashes($_POST['cantidadColor']));
				$producto = htmlspecialchars(addslashes($_POST['producto']));
				$precio = htmlspecialchars(addslashes($_POST['precio']));
				$idProveedor = openssl_decrypt(htmlspecialchars(addslashes($_POST['idProveedor'])), COD, KEY);
				$idSubCategoria = openssl_decrypt(htmlspecialchars(addslashes($_POST['idSubCategoria'])), COD, KEY);
				$idGenero = openssl_decrypt(htmlspecialchars(addslashes($_POST['idGenero'])), COD, KEY);
				$descripcion = htmlspecialchars(addslashes($_POST['descripcion']));

				$imagenPrincipal = date('i-s').$_FILES['imagenPrincipal']['name'];
				$imagenPrincipalTmpName = $_FILES['imagenPrincipal']['tmp_name'];
				move_uploaded_file($imagenPrincipalTmpName, $ruta.$imagenPrincipal);

				$observacion = $_POST['observacion'];
				$activoOferta = 0;
				$precioOferta = "";
				$titulo = "";
				$subTitulo = "";
				$fechaFinOferta = "";
				$imagenOferta = "";
				//Si existe una oferta obtenemos los datos correspondientes a la oferta
				if(isset($_POST['oferta']) && $_POST['oferta'] == "on"){
					$activoOferta = 1;
					$precioOferta = $descripcion = htmlspecialchars(addslashes($_POST['precioOferta']));
					$titulo = htmlspecialchars(addslashes($_POST['titulo']));
					$subTitulo = htmlspecialchars(addslashes($_POST['subTitulo']));
					$fechaFinOferta = htmlspecialchars(addslashes($_POST['fechaFinOferta']));
					$imagenOferta = date("i-s").$_FILES['imagenOferta']['name'];
					$imagenOfertaTmpName = $_FILES['imagenOferta']['tmp_name'];
					move_uploaded_file($imagenOfertaTmpName, $rutaOferta.$imagenOferta);
				}

				$idProducto = $this->almacenModelo->productoNuevo($producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta);

				for ($i=1; $i <= $cantidadColor; $i++) { 
					
					$idTalla = openssl_decrypt(htmlspecialchars(addslashes($_POST['idTalla'.$i])), COD, KEY);
					$color = htmlspecialchars(addslashes($_POST['color'.$i]));
					$cantidad = htmlspecialchars(addslashes($_POST['cantidad'.$i]));
					$imagen1 = "";
					$imagen2 = "";
					$imagen3 = "";
					$imagen4 = ""; 
					$imagen5 = "";
					$imagen6 = "";
					if(isset($_FILES['imagen1'.$i]['name']) && $_FILES['imagen1'.$i]['name'] != ""){
						$imagen1 = date("i-s").$_FILES['imagen1'.$i]['name'];
						$imagen1TmpName = $_FILES['imagen1'.$i]['tmp_name'];
						move_uploaded_file($imagen1TmpName, $ruta.$imagen1);
					}if(isset($_FILES['imagen2'.$i]['name']) && $_FILES['imagen2'.$i]['name'] != ""){
						$imagen2 = date("i-s").$_FILES['imagen2'.$i]['name'];
						$imagen2TmpName = $_FILES['imagen2'.$i]['tmp_name'];
						move_uploaded_file($imagen2TmpName, $ruta.$imagen2);
					}if(isset($_FILES['imagen3'.$i]['name']) && $_FILES['imagen3'.$i]['name'] != ""){
						$imagen3 = date("i-s").$_FILES['imagen3'.$i]['name'];
						$imagen3TmpName = $_FILES['imagen3'.$i]['tmp_name'];
						move_uploaded_file($imagen3TmpName, $ruta.$imagen3);
					}if(isset($_FILES['imagen4'.$i]['name']) && $_FILES['imagen4'.$i]['name'] != ""){
						$imagen4 = date("i-s").$_FILES['imagen4'.$i]['name'];
						$imagen4TmpName = $_FILES['imagen4'.$i]['tmp_name'];
						move_uploaded_file($imagen4TmpName, $ruta.$imagen4);
					}if(isset($_FILES['imagen5'.$i]['name']) && $_FILES['imagen5'.$i]['name'] != ""){
						$imagen5 = date("i-s").$_FILES['imagen5'.$i]['name'];
						$imagen5TmpName = $_FILES['imagen5'.$i]['tmp_name'];
						move_uploaded_file($imagen5TmpName, $ruta.$imagen5);
					}if(isset($_FILES['imagen6'.$i]['name']) && $_FILES['imagen6'.$i]['name'] != ""){
						$imagen6 = date("i-s").$_FILES['imagen6'.$i]['name'];
						$imagen6TmpName = $_FILES['imagen6'.$i]['tmp_name'];
						move_uploaded_file($imagen6TmpName, $ruta.$imagen6);
					}
					$this->almacenModelo->productoNuevoDetalle($idProducto,$idTalla,$color,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad);
				}
			}
		}

		public function selectProveedor(){
			return $this->almacenModelo->selectProveedor();
		}

		public function selectSubCategoria(){
			return $this->almacenModelo->selectSubCategoria();
		}

		public function selectGenero(){
			return $this->almacenModelo->selectGenero();
		}

		public function selectTalla(){
			return $this->almacenModelo->selectTalla();
		}

		public function cantidadDetalle(){
			if($_POST){
				$cantidadColor = $_POST['cantidadColor'];
				include('vista/admin/producto/cantidadDetalle.php');
			}
		}

	}
 ?>