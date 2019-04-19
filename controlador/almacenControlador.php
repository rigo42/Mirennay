<?php 
	//imports
	require_once 'modelo/almacenModelo.php';

	class almacenControlador{

		private $almacenModelo; 
		
		function __construct(){
			$this->almacenModelo = new almacenModelo();
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function index(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/producto/index.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."inicio");
			}
		}

		//SIRVE: Para mostrar la vista de "nuevo"
		//PORQUE: Es nesesario
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/producto/nuevo.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."inicio");
			}
		}

		//SIRVE: Para mostrar la vista de "editar"
		//PORQUE: Es nesesario 
		public function editar(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){

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
				header("Location: ".URL."inicio");
			}
		}

		//SIRVE: Obtener todos los datos generales de un identificador
		//PORQUE: Es necesario construir lo que sea que se pida atra ves de este metodo
		public function construir(){
			return $this->almacenModelo->construir();
		}

		//SIRVE: Mostrar todos los detalles del producto que se le mande la id
		//PORQUE: Es necesario mostrar los detalles de ese producto
		public function mostrarDetalle(){
			return $this->almacenModelo->mostrarDetalle();
		}

		//SIRVE: Mostrar todos los productos con limite de 1000, dinamicamente
		//PORQUE: Es necesario mostrarlos para de ahí escoger el producto a editar o verlo
		public function producto(){
			if($_POST){
				$searchSQL = "";
				if($_POST['search'] != ""){
					$search = htmlspecialchars(strip_tags($_POST['search']));
					$searchSQL = " AND  (p.producto like '%" .$search. "%') ";
					$this->almacenModelo->set("search",$searchSQL);
				}
				$activoSQL = "";
				if($_POST['activo'] != ""){
					$activo = htmlspecialchars(strip_tags($_POST['activo']));
					$activoSQL = " AND  p.activo = $activo ";
					$this->almacenModelo->set("activo",$activoSQL);
				}
				$res = $this->almacenModelo->producto();
				include('vista/admin/producto/producto.php');
			}
		}

		//RAZON: Para insertar un producto nuevo
		//PORQUE: Es necesario insertar productos nuevos
		public function productoNuevo(){
			if($_POST){

                $ruta = "libreria/imgProducto/";
                $rutaOferta = "libreria/imgProductoOferta/";

				$cantidadColor = htmlspecialchars(strip_tags($_POST['cantidadColor']));
				$producto = htmlspecialchars(strip_tags($_POST['producto']));
				$precio = htmlspecialchars(strip_tags($_POST['precio']));
				$idProveedor = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idProveedor'])), COD, KEY);
				$idSubCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idSubCategoria'])), COD, KEY);
				$idGenero = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idGenero'])), COD, KEY);
				$descripcion = htmlspecialchars(strip_tags($_POST['descripcion']));

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
					$precioOferta = $descripcion = htmlspecialchars(strip_tags($_POST['precioOferta']));
					$titulo = htmlspecialchars(strip_tags($_POST['titulo']));
					$subTitulo = htmlspecialchars(strip_tags($_POST['subTitulo']));
					$fechaFinOferta = htmlspecialchars(strip_tags($_POST['fechaFinOferta']));
					$imagenOferta = date("i-s").$_FILES['imagenOferta']['name'];
					$imagenOfertaTmpName = $_FILES['imagenOferta']['tmp_name'];
					move_uploaded_file($imagenOfertaTmpName, $rutaOferta.$imagenOferta);
				}

				$idProducto = $this->almacenModelo->productoNuevo($producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta);

				for ($i=1; $i <= $cantidadColor; $i++) { 
					
					$idTalla = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idTalla'.$i])), COD, KEY);
					$color = htmlspecialchars(strip_tags($_POST['color'.$i]));
					$cantidad = htmlspecialchars(strip_tags($_POST['cantidad'.$i]));
					$cantidadAlerta = htmlspecialchars(strip_tags($_POST['cantidadAlerta'.$i]));
					$codigo = htmlspecialchars(strip_tags($_POST['codigo'.$i]));
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
					$this->almacenModelo->productoNuevoDetalle($idProducto,$idTalla,$color,$codigo,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad,$cantidadAlerta);
				}
			}
		}

		//RAZON: Para cambiar el estado fisico de un producto
		//PORQUE: Para no eliminarlo por completo y solamente evitar que se muestre
		public function productoActivo(){
			if($_POST){
				$idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
				$activo = htmlspecialchars(strip_tags($_POST['activo']));
				$this->almacenModelo->set("idProducto",$idProducto);
				$this->almacenModelo->set("activo",$activo);
				$this->almacenModelo->productoActivo();
			}
		}

		//RAZON: Eliminar el nombre de una imagen de la bd
		//PORQUE: Para visualmente ver que se borre
		public function eliminarImagen(){
			if($_POST){
				$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'], COD, KEY);
				$atributo = $_POST['atributo'];
				$this->almacenModelo->eliminarImagen($idProductoDetalle,$atributo);
			}
		}

		public function eliminarProductoDetalle(){
			if($_POST){
				$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'], COD, KEY);
				$this->almacenModelo->set("idProductoDetalle",$idProductoDetalle);
				$this->almacenModelo->eliminarProductoDetalle();
			}
		}

		public function productoEditar(){
			if($_POST){

                $ruta = "libreria/imgProducto/";
                $rutaOferta = "libreria/imgProductoOferta/";

                $idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
				$cantidadColor = htmlspecialchars(strip_tags($_POST['cantidadColor']));
				$producto = htmlspecialchars(strip_tags($_POST['producto']));
				$precio = htmlspecialchars(strip_tags($_POST['precio']));
				$idProveedor = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idProveedor'])), COD, KEY);
				$idSubCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idSubCategoria'])), COD, KEY);
				$idGenero = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idGenero'])), COD, KEY);
				$descripcion = htmlspecialchars(strip_tags($_POST['descripcion']));
				$activo = htmlspecialchars(strip_tags($_POST['activo']));

				if(!empty($_FILES['imagenPrincipal']['name'])){
					$imagenPrincipal = date('i-s').$_FILES['imagenPrincipal']['name'];
					$imagenPrincipalTmpName = $_FILES['imagenPrincipal']['tmp_name'];
					move_uploaded_file($imagenPrincipalTmpName, $ruta.$imagenPrincipal);
				}else{
					$imagenPrincipal = $_POST['imagenPrincipalBackup'];
				}
				

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
					$precioOferta = $descripcion = htmlspecialchars(strip_tags($_POST['precioOferta']));
					$titulo = htmlspecialchars(strip_tags($_POST['titulo']));
					$subTitulo = htmlspecialchars(strip_tags($_POST['subTitulo']));
					$fechaFinOferta = htmlspecialchars(strip_tags($_POST['fechaFinOferta']));
					if(!empty($_FILES['imagenOferta']['name'])){
						$imagenOferta = date("i-s").$_FILES['imagenOferta']['name'];
						$imagenOfertaTmpName = $_FILES['imagenOferta']['tmp_name'];
						move_uploaded_file($imagenOfertaTmpName, $rutaOferta.$imagenOferta);
					}else{
						$imagenOferta = $_POST['imagenOfertaBackup'];
					}
				}

				$this->almacenModelo->productoEditar($idProducto,$producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta,$activo);

				//Actualizar el producto detalle con buena practica
				$detalleSQL = "";
				$imagenSQL = "";
				$rowDetalle = $_POST['rowDetalle'];

				for ($i=1; $i <= $rowDetalle; $i++){ 

					for ($j=1; $j <= 6 ; $j++) { 
						$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'.$i], COD, KEY);
						$idTalla = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idTalla'.$i])), COD, KEY);
						$color = htmlspecialchars(strip_tags($_POST['color'.$i]));
						$codigo = htmlspecialchars(strip_tags($_POST['codigo'.$i]));
						$cantidad = htmlspecialchars(strip_tags($_POST['cantidad'.$i]));
						$cantidadAlerta = htmlspecialchars(strip_tags($_POST['cantidadAlerta'.$i]));

						if(!empty($_FILES['imagen'.$j.$i]['name'])){
							//Imagen
							$imagen = date("i-s").$_FILES['imagen'.$j.$i]['name'];
							$imagenTmpName = $_FILES['imagen'.$j.$i]['tmp_name'];
							move_uploaded_file($imagenTmpName, $ruta.$imagen);
							$imagenSQL .= ", imagen".$j." = '".$imagen."' ";
						}						
					}

					$detalleSQL .= " id_talla = $idTalla, codigo = '$codigo', color = '$color', cantidad =  $cantidad, cantidad_alerta = $cantidadAlerta ".$imagenSQL;

					$this->almacenModelo->set("idProductoDetalle",$idProductoDetalle);
					$this->almacenModelo->detalleEditar($detalleSQL);

					$imagenSQL = "";
					$detalleSQL = "";

				}
				
				
				$rowDetalleFin = $cantidadColor+$rowDetalle;
				++$rowDetalle;
				
				for ($i = $rowDetalle; $i <= $rowDetalleFin; $i++) { 
					
					$idTalla = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idTalla'.$i])), COD, KEY);
					$color = htmlspecialchars(strip_tags($_POST['color'.$i]));
					$codigo = htmlspecialchars(strip_tags($_POST['codigo'.$i]));
					$cantidad = htmlspecialchars(strip_tags($_POST['cantidad'.$i]));
					$cantidadAlerta = htmlspecialchars(strip_tags($_POST['cantidadAlerta'.$i]));
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
					$this->almacenModelo->productoNuevoDetalle($idProducto,$idTalla,$color,$codigo,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad,$cantidadAlerta);
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

		//RAZON: Mostrar el formulario de cuantos productos nuevos se intertaran
		//PORQUE: Es necesario para insertar y editar
		public function cantidadDetalle(){
			if($_POST){
				$cantidadColor = $_POST['cantidadColor'];
				$inicioCantidad = $_POST['inicioCantidad'];
				include('vista/admin/producto/cantidadDetalle.php');
			}
		}

	}
 ?>