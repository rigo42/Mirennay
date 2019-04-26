<?php

require_once 'modelo/adminEmpleadoModelo.php';
require_once 'controlador/validarCorreoControlador.php';
require_once 'controlador/enviarCorreoControlador.php';

class adminEmpleadoControlador {

    private $adminEmpleadoModelo;
    private $validarCorreoControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminEmpleadoModelo = new adminEmpleadoModelo();
        $this->validarCorreoControlador = new validarCorreoControlador();
    } 

	//SIRVE: Para mostrar la vista principal
	//PORQUE: Es necesaria una vista
	public function index(){
		session_start();
		if(isset($_SESSION['idEmpleado'])){
			if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/empleado/index.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."adminPuntoVenta");
			}
		}else{
			header("Location: ".URL."adminLogin");
		}
	}

	public function nuevo(){
		session_start();
		if(isset($_SESSION['idEmpleado'])){
			if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				include('vista/admin/empleado/nuevo.php');

				include('vista/admin/footer/index.php');
			}else{
				header("Location: ".URL."adminPuntoVenta");
			}
		}else{
			header("Location: ".URL."adminLogin");
		}
	}

	public function editar(){
		session_start();
		if(isset($_SESSION['idEmpleado'])){
			if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
				include('vista/admin/head/index.php');
				include('vista/admin/header/index.php');
				include('vista/admin/menu/index.php');

				if(isset($_GET['idEmpleado'])){
					$idEmpleado = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idEmpleado'], COD, KEY)));
					$idEmpleadoSQL = " AND e.id_empleado = $idEmpleado";
					$this->adminEmpleadoModelo->set("idEmpleado",$idEmpleadoSQL);
					$res = $this->adminEmpleadoModelo->construir();
					foreach ($res as $key => $value) {}
					include('vista/admin/empleado/editar.php');
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

	//SIRVE: Mostrar todos los productos con limite de 1000, dinamicamente
	//PORQUE: Es necesario mostrarlos para de ahí escoger el producto a editar o verlo
	public function mostrar(){
		session_start();
		if(isset($_SESSION['idEmpleado'])){
			if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
				if($_POST){
					$searchSQL = "";
					if($_POST['search'] != ""){
						$search = htmlspecialchars(strip_tags($_POST['search']));
						$searchSQL = " AND  (e.empleado like '%" .$search. "%' OR e.nombre like '%" .$search. "%' OR e.apellido_paterno like '%" .$search. "%' OR e.apellido_materno like '%" .$search. "%' OR r.rol like '%" .$search. "%') ";
						$this->adminEmpleadoModelo->set("search",$searchSQL);
					}
					$activoSQL = "";
					if($_POST['activo'] != ""){
						$activo = htmlspecialchars(strip_tags($_POST['activo']));
						$activoSQL = " AND  e.activo = $activo ";
						$this->adminEmpleadoModelo->set("activo",$activoSQL);
					}
					$res = $this->adminEmpleadoModelo->mostrar();
					include('vista/admin/empleado/empleado.php');
				}
			}else{
				header("Location: ".URL."adminPuntoVenta");
			}
		}else{
			header("Location: ".URL."adminLogin");
		}
	}

	public function empleadoServlet(){
		session_start();
		if(isset($_SESSION['idEmpleado'])){
			if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
				if($_POST){
					//Obtenemos datos via post
					$correo = htmlspecialchars(strip_tags($_POST['correo']));
					$validarCorreo = $this->validarCorreoControlador->validarCorreo($correo);
					if($validarCorreo){
						$celular = htmlspecialchars(strip_tags($_POST['celular']));
						if(is_numeric($celular)){
							$salario = htmlspecialchars(strip_tags($_POST['salario']));
							if(is_numeric($salario)){

								$idRol = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idRol'])), COD, KEY);
								$nombre = htmlspecialchars(strip_tags($_POST['nombre']));
								$apellidoPaterno = htmlspecialchars(strip_tags($_POST['apellidoPaterno']));
								$apellidoMaterno = htmlspecialchars(strip_tags($_POST['apellidoMaterno']));
								$nss = htmlspecialchars(strip_tags($_POST['nss']));

								//Seteamos los datos obtenidos al modelo
								$this->adminEmpleadoModelo->set("idRol",$idRol);
								$this->adminEmpleadoModelo->set("nombre",$nombre);
								$this->adminEmpleadoModelo->set("apellidoPaterno",$apellidoPaterno);
								$this->adminEmpleadoModelo->set("apellidoMaterno",$apellidoMaterno);
								$this->adminEmpleadoModelo->set("nss",$nss);
								$this->adminEmpleadoModelo->set("salario",$salario);
								$this->adminEmpleadoModelo->set("correo",$correo);
								$this->adminEmpleadoModelo->set("celular",$celular);

								if($_POST['actividad'] == "nuevo"){

									$empleado = $this->generarMatricula();
									$password = password_hash("12345678", PASSWORD_DEFAULT,['cost' => 15]);

									$this->adminEmpleadoModelo->set("password",$password);
									$this->adminEmpleadoModelo->set("empleado",$empleado);
									
									$this->adminEmpleadoModelo->nuevo();

									$asunto = "Datos de usuario";
									$mensaje = "Usuario: $empleado\n Password: 12345678 \n Salario: \n $salario";

									$enviarCorreoControlador = new enviarCorreoControlador();
									$retorno = $enviarCorreoControlador->enviarCorreo($correo,$asunto,$mensaje);
									if($retorno){
										echo 4; //Todo bien se envio
									}else{
										echo "Ocurrio un error al enviar el correo";
									}
									
								}else if($_POST['actividad'] == "editar"){

									$idEmpleado = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idEmpleado'])), COD, KEY);
									$activo = htmlspecialchars(strip_tags($_POST['activo']));

									$this->adminEmpleadoModelo->set("idEmpleado",$idEmpleado);
									$this->adminEmpleadoModelo->set("activo",$activo);

									//Editamos el usuario wiiiii :3
									$this->adminEmpleadoModelo->editar();
									echo 5; //Empleado modificado correctamente
								}
								
							}else{
								echo 3; //Salario mal
							}
						}else{
							echo 2; //Celular mal
						}
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

	public function generarMatricula(){
		$matricula = $this->adminEmpleadoModelo->generarMatricula();
		return $matricula;
	}

	public function selectRol(){
		return $this->adminEmpleadoModelo->selectRol();
	}

}
?>
