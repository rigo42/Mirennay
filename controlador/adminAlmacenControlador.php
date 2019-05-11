<?php 
	//imports
	require_once 'modelo/adminAlmacenModelo.php';
	require_once 'controlador/optimizarImagenControlador.php';

	class adminAlmacenControlador{

		private $adminAlmacenModelo; 
		
		function __construct(){
			$this->adminAlmacenModelo = new adminAlmacenModelo();
			$this->optimizarImagenControlador = new optimizarImagenControlador();
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function index(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){

					include('vista/admin/head/index.php');
					include('vista/admin/header/index.php');
					include('vista/admin/menu/index.php');

					include('vista/admin/almacen/index.php');

					include('vista/admin/footer/index.php');

				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//SIRVE: Para mostrar la vista de "nuevo"
		//PORQUE: Es nesesario
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){

					include('vista/admin/head/index.php');
					include('vista/admin/header/index.php');
					include('vista/admin/menu/index.php');

					include('vista/admin/almacen/nuevo.php');

					include('vista/admin/footer/index.php');

				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//SIRVE: Para mostrar la vista de "editar"
		//PORQUE: Es nesesario 
		public function editar(){ 
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){

					include('vista/admin/head/index.php');
					include('vista/admin/header/index.php');
					include('vista/admin/menu/index.php');

					if(isset($_GET['idProducto'])){
			    		include('vista/admin/almacen/editar.php');
					}else{
				    	echo "Por favor envie el identificador del producto";
					}

				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}

		}

		//SIRVE: Obtener todos los datos generales de un identificador
		//PORQUE: Es necesario construir lo que sea que se pida atra ves de este metodo
		public function construir(){
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){

					return $this->adminAlmacenModelo->construir();

				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//SIRVE: Mostrar todos los detalles del producto que se le mande la id
		//PORQUE: Es necesario mostrar los detalles de ese producto
		public function mostrarDetalle(){
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){

					return $this->adminAlmacenModelo->mostrarDetalle();
					
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//SIRVE: Mostrar todos los productos con limite de 1000, dinamicamente
		//PORQUE: Es necesario mostrarlos para de ahí escoger el producto a editar o verlo
		public function producto(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
					if($_POST){
						$searchSQL = "";
						if($_POST['search'] != ""){
							$search = htmlspecialchars(strip_tags($_POST['search']));
							$searchSQL = " AND  (p.producto like '%" .$search. "%') ";
							$this->adminAlmacenModelo->set("search",$searchSQL);
						}
						$activoSQL = "";
						if($_POST['activo'] != ""){
							$activo = htmlspecialchars(strip_tags($_POST['activo']));
							$activoSQL = " AND  p.activo = $activo ";
							$this->adminAlmacenModelo->set("activo",$activoSQL);
						}
						$res = $this->adminAlmacenModelo->producto();
						include('vista/admin/almacen/producto.php');
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//RAZON: Para insertar un producto nuevo
		//PORQUE: Es necesario insertar productos nuevos
		public function productoNuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
					if($_POST){

						$extencion = ".jpeg";
						$calidad = 70;
		                $ruta = "libreria/imgProducto/";
		                $rutaOferta = "libreria/imgProductoOferta/";

						$cantidadColor = htmlspecialchars(strip_tags($_POST['cantidadColor']));
						$producto = htmlspecialchars(strip_tags($_POST['producto']));
						$precio = htmlspecialchars(strip_tags($_POST['precio']));
						$idProveedor = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idProveedor'])), COD, KEY);
						$idSubCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idSubCategoria'])), COD, KEY);
						$idGenero = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idGenero'])), COD, KEY);
						$descripcion = htmlspecialchars(strip_tags($_POST['descripcion']));

						$imagenPrincipal = date('i-s').$_FILES['imagenPrincipal']['name'].$extencion;
						$imagenPrincipalTmpName = $_FILES['imagenPrincipal']['tmp_name'];

						if($this->optimizarImagenControlador->optimizarImagen($imagenPrincipalTmpName, $ruta.$imagenPrincipal, $calidad)){

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
								$imagenOferta = date("i-s").$_FILES['imagenOferta']['name'].$extencion;
								$imagenOfertaTmpName = $_FILES['imagenOferta']['tmp_name'];
								if(!$this->optimizarImagenControlador->optimizarImagen($imagenOfertaTmpName, $rutaOferta.$imagenOferta, $calidad)){
									echo "No se pudo guardar la imagen oferta";
								}
							}

							$idProducto = $this->adminAlmacenModelo->productoNuevo($producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta);

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
									$imagen1 = date("i-s").$_FILES['imagen1'.$i]['name'].$extencion;
									$imagen1TmpName = $_FILES['imagen1'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen1TmpName, $ruta.$imagen1, $calidad);
								}if(isset($_FILES['imagen2'.$i]['name']) && $_FILES['imagen2'.$i]['name'] != ""){
									$imagen2 = date("i-s").$_FILES['imagen2'.$i]['name'].$extencion;
									$imagen2TmpName = $_FILES['imagen2'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen2TmpName, $ruta.$imagen2, $calidad);
								}if(isset($_FILES['imagen3'.$i]['name']) && $_FILES['imagen3'.$i]['name'] != ""){
									$imagen3 = date("i-s").$_FILES['imagen3'.$i]['name'].$extencion;
									$imagen3TmpName = $_FILES['imagen3'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen3TmpName, $ruta.$imagen3, $calidad);
								}if(isset($_FILES['imagen4'.$i]['name']) && $_FILES['imagen4'.$i]['name'] != ""){
									$imagen4 = date("i-s").$_FILES['imagen4'.$i]['name'].$extencion;
									$imagen4TmpName = $_FILES['imagen4'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen4TmpName, $ruta.$imagen4, $calidad);
								}if(isset($_FILES['imagen5'.$i]['name']) && $_FILES['imagen5'.$i]['name'] != ""){
									$imagen5 = date("i-s").$_FILES['imagen5'.$i]['name'].$extencion;
									$imagen5TmpName = $_FILES['imagen5'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen5TmpName, $ruta.$imagen5, $calidad);
								}if(isset($_FILES['imagen6'.$i]['name']) && $_FILES['imagen6'.$i]['name'] != ""){
									$imagen6 = date("i-s").$_FILES['imagen6'.$i]['name'].$extencion;
									$imagen6TmpName = $_FILES['imagen6'.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagen6TmpName, $ruta.$imagen6, $calidad);
								}
								$this->adminAlmacenModelo->productoNuevoDetalle($idProducto,$idTalla,$color,$codigo,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad,$cantidadAlerta);
							}
							echo 1;
						}else{
							echo "No se pudo guardar la imagen principal";
						}
					}else{
						echo "Envie los datos post";
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//RAZON: Para cambiar el estado fisico de un producto
		//PORQUE: Para no eliminarlo por completo y solamente evitar que se muestre
		public function productoActivo(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						$idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
						$activo = htmlspecialchars(strip_tags($_POST['activo']));
						$this->adminAlmacenModelo->set("idProducto",$idProducto);
						$this->adminAlmacenModelo->set("activo",$activo);
						$this->adminAlmacenModelo->productoActivo();
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
			
		}

		//RAZON: Eliminar el nombre de una imagen de la bd
		//PORQUE: Para visualmente ver que se borre
		public function eliminarImagen(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						$ruta = "libreria/imgProducto/";
						$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'], COD, KEY);
						$atributo = $_POST['atributo'];
						$imagen = $_POST['imagen'];
						if(unlink($ruta.$imagen)){
							$this->adminAlmacenModelo->eliminarImagen($idProductoDetalle,$atributo);
							echo 1; // todo bien
						}else{
							echo "Error al eliminar imagen";
						}
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function eliminarProductoDetalle(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						$idProductoDetalle = openssl_decrypt($_POST['idProductoDetalle'], COD, KEY);
						$this->adminAlmacenModelo->set("idProductoDetalle",$idProductoDetalle);
						$this->adminAlmacenModelo->eliminarProductoDetalle();
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function productoEditar(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					
					if($_POST){

						$extencion = ".jpeg";
						$calidad = 70;
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

							//Eliminamos la anterior imagen
	                        if(!empty($_POST['imagenPrincipalBackup'])){
	                            if(file_exists($ruta.$_POST['imagenPrincipalBackup'])){
	                               if(!unlink($ruta.$_POST['imagenPrincipalBackup'])){
	                               		echo "No se pudo eliminar la imagen anterior para actualizar a esta nueva: ".$_POST['imagenPrincipalBackup'];
									}
	                            }else{
	                            	echo "No existe la ruta para eliminar la imagen ".$ruta.$_POST['imagenPrincipalBackup'];
	                            }
	                        }

							$imagenPrincipal = date('i-s').$_FILES['imagenPrincipal']['name'].$extencion;
							$imagenPrincipalTmpName = $_FILES['imagenPrincipal']['tmp_name'];
							if(!$this->optimizarImagenControlador->optimizarImagen($imagenPrincipalTmpName, $ruta.$imagenPrincipal, $calidad)){
								echo "Error al optimizar la imagen principal";
							}
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
								//Eliminamos la anterior imagen
		                        if(!empty($_POST['imagenOfertaBackup'])){
		                            if(file_exists($ruta.$_POST['imagenOfertaBackup'])){
		                                unlink($ruta.$_POST['imagenOfertaBackup']);
		                            }
		                        }

								$imagenOferta = date("i-s").$_FILES['imagenOferta']['name'].$extencion;
								$imagenOfertaTmpName = $_FILES['imagenOferta']['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagenOfertaTmpName, $rutaOferta.$imagenOferta, $calidad);
							}else{
								$imagenOferta = $_POST['imagenOfertaBackup'];
							}
						}

						$this->adminAlmacenModelo->productoEditar($idProducto,$producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta,$activo);

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
									$imagen = date("i-s").$_FILES['imagen'.$j.$i]['name'].$extencion;
									$imagenTmpName = $_FILES['imagen'.$j.$i]['tmp_name'];
									$this->optimizarImagenControlador->optimizarImagen($imagenTmpName, $ruta.$imagen, $calidad);
									$imagenSQL .= ", imagen".$j." = '".$imagen."' ";
								}						
							}

							$detalleSQL .= " id_talla = $idTalla, codigo = '$codigo', color = '$color', cantidad =  $cantidad, cantidad_alerta = $cantidadAlerta ".$imagenSQL;

							$this->adminAlmacenModelo->set("idProductoDetalle",$idProductoDetalle);
							$this->adminAlmacenModelo->detalleEditar($detalleSQL);

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
								$imagen1 = date("i-s").$_FILES['imagen1'.$i]['name'].$extencion;
								$imagen1TmpName = $_FILES['imagen1'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen1TmpName, $ruta.$imagen1, $calidad);

							}if(isset($_FILES['imagen2'.$i]['name']) && $_FILES['imagen2'.$i]['name'] != ""){
								$imagen2 = date("i-s").$_FILES['imagen2'.$i]['name'].$extencion;
								$imagen2TmpName = $_FILES['imagen2'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen2TmpName, $ruta.$imagen2, $calidad);

							}if(isset($_FILES['imagen3'.$i]['name']) && $_FILES['imagen3'.$i]['name'] != ""){
								$imagen3 = date("i-s").$_FILES['imagen3'.$i]['name'].$extencion;
								$imagen3TmpName = $_FILES['imagen3'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen3TmpName, $ruta.$imagen3, $calidad);

							}if(isset($_FILES['imagen4'.$i]['name']) && $_FILES['imagen4'.$i]['name'] != ""){
								$imagen4 = date("i-s").$_FILES['imagen4'.$i]['name'].$extencion;
								$imagen4TmpName = $_FILES['imagen4'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen4TmpName, $ruta.$imagen4, $calidad);

							}if(isset($_FILES['imagen5'.$i]['name']) && $_FILES['imagen5'.$i]['name'] != ""){
								$imagen5 = date("i-s").$_FILES['imagen5'.$i]['name'].$extencion;
								$imagen5TmpName = $_FILES['imagen5'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen5TmpName, $ruta.$imagen5, $calidad);

							}if(isset($_FILES['imagen6'.$i]['name']) && $_FILES['imagen6'.$i]['name'] != ""){
								$imagen6 = date("i-s").$_FILES['imagen6'.$i]['name'].$extencion;
								$imagen6TmpName = $_FILES['imagen6'.$i]['tmp_name'];
								$this->optimizarImagenControlador->optimizarImagen($imagen6TmpName, $ruta.$imagen6, $calidad);

							}
							$this->adminAlmacenModelo->productoNuevoDetalle($idProducto,$idTalla,$color,$codigo,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad,$cantidadAlerta);
						} 
						echo 1;
					}else{
						echo "No envio los datos post";
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function selectProveedor(){
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
					return $this->adminAlmacenModelo->selectProveedor();
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function selectSubCategoria(){
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
					return $this->adminAlmacenModelo->selectSubCategoria();
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function selectGenero(){
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
					return $this->adminAlmacenModelo->selectGenero();
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function selectTalla(){
			return $this->adminAlmacenModelo->selectTalla();
		}

		//RAZON: Mostrar el formulario de cuantos productos nuevos se intertaran
		//PORQUE: Es necesario para insertar y editar
		public function cantidadDetalle(){
			if($_POST){
				$cantidadColor = $_POST['cantidadColor'];
				$inicioCantidad = $_POST['inicioCantidad'];
				include('vista/admin/almacen/cantidadDetalle.php');
			}
		}

	}
 ?>