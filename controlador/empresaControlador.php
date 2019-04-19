<?php 
	//imports
	require_once 'modelo/empresaModelo.php';

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
		public function index(){
			session_start();
			if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/empresa/editar.php');

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

	}
 ?>