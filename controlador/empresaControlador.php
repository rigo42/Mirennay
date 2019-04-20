<?php 
	//imports
	require_once 'modelo/empresaModelo.php';
	require_once 'controlador/validarCorreoControlador.php';

	class empresaControlador{

		private $empresaModelo; 
		
		function __construct(){
			$this->empresaModelo = new empresaModelo();
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function index(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/empresa/index.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."inicio");
			}
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function nuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');
					
				include('vista/admin/empresa/nuevo.php');
				
				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."inicio");
			}
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function editar(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				if(!empty($_GET['idEmpresa'])){
					$idEmpresa = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idEmpresa'], COD, KEY)));
					$idEmpresaSQL = " AND e.id_empresa = $idEmpresa";
					$this->empresaModelo->set("idEmpresa",$idEmpresaSQL);
					$res = $this->empresaModelo->construir();
					foreach ($res as $key => $value) {}
					include('vista/admin/empresa/editar.php');
				}else{
					echo "Por favor envie el identificador";
				}
				
				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."inicio");
			}
		}

		public function mostrar(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				if($_POST){
					$searchSQL = "";
					if($_POST['search'] != ""){
						$search = htmlspecialchars(strip_tags($_POST['search']));
						$searchSQL = " AND (e.empresa like '%" .$search. "%') ";
						$this->empresaModelo->set("search",$searchSQL);
					}
					$activoSQL = "";
					if($_POST['activo'] != ""){
						$activo = htmlspecialchars(strip_tags($_POST['activo']));
						$activoSQL = " AND e.activo = $activo ";
						$this->empresaModelo->set("activo",$activoSQL);
					}
					$res = $this->empresaModelo->mostrar();
					include('vista/admin/empresa/empresa.php');
				}
			}else{
				header("Location: ".URL."inicio");
			}
		}

		public function formEmpresaNuevo(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
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
						$this->empresaModelo->set("empresa",$empresa);
						$this->empresaModelo->set("direccion",$direccion);
						$this->empresaModelo->set("celular",$celular);
						$this->empresaModelo->set("correo",$correo);
						$this->empresaModelo->set("observacion",$observacion);
						$this->empresaModelo->set("activo",1);

						//Editamos los datos
						$this->empresaModelo->nuevo();
					}else{
						echo 1; //Correo mal
					}					
				}
			}else{
				header("Location: ".URL."inicio");
			}
		}

		public function formEmpresaEditar(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
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
						$this->empresaModelo->set("idEmpresa",$idEmpresa);
						$this->empresaModelo->set("empresa",$empresa);
						$this->empresaModelo->set("direccion",$direccion);
						$this->empresaModelo->set("celular",$celular);
						$this->empresaModelo->set("correo",$correo);
						$this->empresaModelo->set("observacion",$observacion);
						$this->empresaModelo->set("activo",$activo);

						//Editamos los datos
						$this->empresaModelo->editar();
					}else{
						echo 1; //Correo mal
					}					
				}
			}else{
				header("Location: ".URL."inicio");
			}
		}

	}
 ?>