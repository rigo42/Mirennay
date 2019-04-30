<?php 
	//imports
	require_once 'modelo/adminLoginModelo.php';
	require_once 'controlador/validarCorreoControlador.php';
	require_once 'controlador/enviarCorreoControlador.php';

	class adminLoginControlador{

		private $adminLoginModelo;
		private $validarCorreoControlador; 
		private $enviarCorreoControlador;

		function __construct(){
			$this->adminLoginModelo = new adminLoginModelo();
		}

		//SIRVE: Para mostrar la vista principal
		//PORQUE: Es necesaria una vista
		public function index(){
			session_start();
			include('vista/admin/head/index.php');
			include('vista/admin/login/index.php');
		}

		public function password(){
			session_start();
			include('vista/admin/head/index.php');
			if(isset($_GET['codigoVerificacion'])){
				$codigoVerificacion = htmlspecialchars(addslashes($_GET['codigoVerificacion']));
				$codigoVerificacionSQL = " AND codigo_verificacion = '$codigoVerificacion' ";
				$this->adminLoginModelo->set("codigoVerificacion",$codigoVerificacionSQL);
				$res = $this->adminLoginModelo->construir();
				$row = $res->rowCount();
           		if($row > 0){
					foreach ($res as $key => $value) {}
					if($value['hoy'] < $value['fecha_limite_verificacion']){
						include('vista/admin/login/password.php');
					}else{
						echo "Ya fue vencido este codigo de su fecha limite";
					}
				}else{
					echo "Ya fue vencido este codigo de su fecha limite";
				}
			}else{
				echo "No envio el codigo";
			}
		}

		public function cambiarPassword(){
			session_start();
			if($_POST){
				$correo = htmlspecialchars(addslashes($_POST['correo']));
				$passwordModificacion = password_hash(htmlspecialchars(addslashes($_POST['password'])), PASSWORD_DEFAULT,['cost' => 15]);

				$this->adminLoginModelo->set("passwordModificacion",$passwordModificacion);
				$this->adminLoginModelo->set("correo",$correo);

				$this->adminLoginModelo->cambiarPassword();
				echo 1;
			}
		}

		public function iniciarSesion(){
			if($_POST){
				//Recibir datos
				$empleado = htmlspecialchars(addslashes($_POST['empleado']));
				$password = htmlspecialchars(addslashes($_POST['password']));

				//Setear el nombre de usuario que queramos obtener los datos
				$empleadoSQL = " AND (e.empleado = '$empleado') OR (e.correo = '$empleado') ";
				$this->adminLoginModelo->set("empleado",$empleadoSQL);

				//Obtener los datos especificos del usuario
				$res = $this->adminLoginModelo->construir();
				$row = $res->rowCount();
				if($row > 0){
					foreach ($res as $key => $value) { }

					if($value['password_modificacion_activo'] == 1){
						$hash = $value['password_modificacion'];
					}else{
						$hash = $value['password'];
					}

					if(password_verify($password, $hash)){
						session_start();
						$_SESSION['idEmpleado'] = $value['id_empleado'];
						$_SESSION['empleado'] = $value['empleado'];
						$_SESSION['rolEmpleado'] = $value['rol'];
						$_SESSION['nombre'] = $value['nombre'];
						$_SESSION['apellidoPaterno'] = $value['apellido_paterno'];
						$_SESSION['apellidoMaterno'] = $value['apellido_materno'];
						$_SESSION['nss'] = $value['nss'];
						$_SESSION['salario'] = $value['salario'];
						$_SESSION['correoEmpleado'] = $value['correo'];
						$_SESSION['imagenEmpleado'] = $value['imagen'];
						$_SESSION['fechaAlta'] = $value['fecha_alta'];
						echo 1; //Todo bien
					}else{
						echo 2; //Usuario o contrraseña mal
					}
				}else{
					echo 2; //Usuario o contrraseña mal
				}
				
			}
		}

		public function activarCodigoVerificacion(){
			//date_default_timezone_set("Mexico/General");
			if($_POST){
				$correo = htmlspecialchars(addslashes($_POST['correo']));

				//Iniciar instancia
				$this->validarCorreoControlador = new validarCorreoControlador();
				$this->enviarCorreoControlador = new enviarCorreoControlador();

				$correoValidado = $this->validarCorreoControlador->validarCorreo($correo);

				if($correoValidado){

					$correoSQL = " AND e.correo = '$correo' ";
					$activoSQL = " AND e.activo = 1";

					//Setear datos 
					$this->adminLoginModelo->set("correo",$correoSQL);
					$this->adminLoginModelo->set("activo",$activoSQL);

					$res = $this->adminLoginModelo->construir();
					$row = $res->rowCount();
					if($row > 0){

						//Datos del correo
						$codigoVerificacion = $this->crearCodigoVerificacion();
	            		$fechaLimiteVerificacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
	            		$asunto = "Recuperación de password";
	            		$link = URL."adminLogin/password?codigoVerificacion=$codigoVerificacion";
	            		$texto = "Entra a este link, solo tienes 24 horas antes de que caduque <br> $link";

	            		//Setear correo,codigo,fechaLimite
	            		$this->adminLoginModelo->set("correo",$correo);
	            		$this->adminLoginModelo->set("codigoVerificacion",$codigoVerificacion);
	            		$this->adminLoginModelo->set("fechaLimiteVerificacion",$fechaLimiteVerificacion);

	            		//Ejecutar la funcion que modifica que se activara el codigo
	            		$this->adminLoginModelo->activarCodigoVerificacion();

	            		$mensaje = file_get_contents('vista/cliente/correo/basico.php');
                        $mensaje = str_replace("{{year}}", date('Y'), $mensaje);
                        $mensaje = str_replace("{{asunto}}", $asunto, $mensaje);
                        $mensaje = str_replace("{{mensaje}}", $texto, $mensaje);

						$validarCorreo = $this->enviarCorreoControlador->enviarCorreo($correo,$asunto,$mensaje);
						if($validarCorreo == 1){
							echo 1;
						}else{
							echo $validarCorreo;
						}
					}else{
						echo 3; //No se encontro ningun dato con ese correo
					}					
				}else{
					echo 2;
				}
			}
		}

		public function crearCodigoVerificacion(){
	        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
	        srand((double)microtime()*1000000);
	        $i = 0;
	        $pass = '' ;
	    
	        while ($i <= 7) {
	            $num = rand() % 33;
	            $tmp = substr($chars, $num, 1);
	            $pass = $pass . $tmp;
	            $i++;
	        }
	    
	        return time().$pass;
	    }

		public function cerrarSesion(){
			session_start();
			session_unset();
			session_destroy();
		}


	}
 ?>