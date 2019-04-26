<?php 
	//imports
	require_once 'modelo/adminEmpresaModelo.php';
	require_once 'controlador/validarCorreoControlador.php';

	class adminEmpresaControlador{

		private $adminEmpresaModelo; 
		
		function __construct(){
			$this->adminEmpresaModelo = new adminEmpresaModelo();
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

					include('vista/admin/empresa/index.php');

					include('vista/admin/footer/index.php');
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}

		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					include('vista/admin/head/index.php');
					include('vista/admin/header/index.php');
					include('vista/admin/menu/index.php');
						
					include('vista/admin/empresa/nuevo.php');
					
					include('vista/admin/footer/index.php');
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function editar(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					include('vista/admin/head/index.php');
					include('vista/admin/header/index.php');
					include('vista/admin/menu/index.php');

					if(isset($_GET['idEmpresa'])){
						$idEmpresa = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idEmpresa'], COD, KEY)));
						$idEmpresaSQL = " AND e.id_empresa = $idEmpresa";
						$this->adminEmpresaModelo->set("idEmpresa",$idEmpresaSQL);
						$res = $this->adminEmpresaModelo->construir();
						foreach ($res as $key => $value) {}
						include('vista/admin/empresa/editar.php');
					}else{
						echo "Por favor envie el identificador";
					}
					
					include('vista/admin/footer/index.php');
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function mostrar(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						$searchSQL = "";
						if($_POST['search'] != ""){
							$search = htmlspecialchars(strip_tags($_POST['search']));
							$searchSQL = " AND (e.empresa like '%" .$search. "%') ";
							$this->adminEmpresaModelo->set("search",$searchSQL);
						}
						$activoSQL = "";
						if($_POST['activo'] != ""){
							$activo = htmlspecialchars(strip_tags($_POST['activo']));
							$activoSQL = " AND e.activo = $activo ";
							$this->adminEmpresaModelo->set("activo",$activoSQL);
						}
						$res = $this->adminEmpresaModelo->mostrar();
						include('vista/admin/empresa/empresa.php');
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function formEmpresaNuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						//Instancia para validar un correo
						$validarCorreoControlador = new validarCorreoControlador();
						$correo = htmlspecialchars(strip_tags($_POST['correo']));
						$correoValidado = $validarCorreoControlador->validarCorreo($correo);

						if($correoValidado){
							//Obtenemos los datos
							$empresa = htmlspecialchars(strip_tags($_POST['empresa']));
							$direccion = htmlspecialchars(strip_tags($_POST['direccion']));
							$celular = htmlspecialchars(strip_tags($_POST['celular']));
							$observacion = htmlspecialchars(strip_tags($_POST['observacion']));

							//Seteamos los datos
							$this->adminEmpresaModelo->set("empresa",$empresa);
							$this->adminEmpresaModelo->set("direccion",$direccion);
							$this->adminEmpresaModelo->set("celular",$celular);
							$this->adminEmpresaModelo->set("correo",$correo);
							$this->adminEmpresaModelo->set("observacion",$observacion);
							$this->adminEmpresaModelo->set("activo",1);

							//Editamos los datos
							$this->adminEmpresaModelo->nuevo();
						}else{
							echo 1; //Correo mal
						}					
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

		public function formEmpresaEditar(){
			session_start();
			if(isset($_SESSION['idEmpleado'])){
				if($_SESSION['rolEmpleado'] == "admin"){
					if($_POST){
						//Instancia para validar un correo
						$validarCorreoControlador = new validarCorreoControlador();
						$correo = htmlspecialchars(strip_tags($_POST['correo']));
						$correoValidado = $validarCorreoControlador->validarCorreo($correo);

						if($correoValidado){
							//Obtenemos los datos
							$idEmpresa = htmlspecialchars(strip_tags(openssl_decrypt($_POST['idEmpresa'], COD, KEY)));
							$empresa = htmlspecialchars(strip_tags($_POST['empresa']));
							$direccion = htmlspecialchars(strip_tags($_POST['direccion']));
							$celular = htmlspecialchars(strip_tags($_POST['celular']));
							$observacion = htmlspecialchars(strip_tags($_POST['observacion']));
							$activo = htmlspecialchars(strip_tags($_POST['activo']));

							//Seteamos los datos
							$this->adminEmpresaModelo->set("idEmpresa",$idEmpresa);
							$this->adminEmpresaModelo->set("empresa",$empresa);
							$this->adminEmpresaModelo->set("direccion",$direccion);
							$this->adminEmpresaModelo->set("celular",$celular);
							$this->adminEmpresaModelo->set("correo",$correo);
							$this->adminEmpresaModelo->set("observacion",$observacion);
							$this->adminEmpresaModelo->set("activo",$activo);

							//Editamos los datos
							$this->adminEmpresaModelo->editar();
						}else{
							echo 1; //Correo mal
						}					
					}
				}else{
					header("Location: ".URL."adminPuntoVenta");
				}
			}else{
				header("Location: ".URL."adminLogin");
			}
		}

	}
 ?>