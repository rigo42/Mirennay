<?php

require_once 'modelo/loginModelo.php';
require_once 'controlador/productoFavoritoControlador.php';
require_once 'controlador/productoCarritoControlador.php';
require_once 'controlador/validarCorreoControlador.php';
require_once 'controlador/enviarCorreoControlador.php';

class loginControlador {

    private $loginModelo;
    private $productoFavoritoControlador;
    private $productoCarritoControlador;
    private $validarCorreoControlador;
    private $enviarCorreoControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->loginModelo = new loginModelo();
        $this->productoFavoritoControlador = new productoFavoritoControlador();
        $this->productoCarritoControlador = new productoCarritoControlador();
    } 

	public function index(){
        session_start();
		include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
		include('vista/cliente/menu/index.php');

        include('vista/cliente/login/index.php');

    	include('vista/cliente/contacto/index.php');
    	include('vista/cliente/footer/index.php');
	}

    public function nuevo(){
        session_start();
        include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
        include('vista/cliente/menu/index.php');
        
        include('vista/cliente/login/usuarioNuevo.php');

        include('vista/cliente/contacto/index.php');
        include('vista/cliente/footer/index.php');
    }

    public function password(){
        session_start();
        include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
        include('vista/cliente/menu/index.php');
        
       if(isset($_GET['codigoVerificacion'])){
            $codigoVerificacion = htmlspecialchars(addslashes($_GET['codigoVerificacion']));
            $codigoVerificacionSQL = " AND codigo_verificacion = '$codigoVerificacion' ";
            $this->loginModelo->set("codigoVerificacion",$codigoVerificacionSQL);
            $res = $this->loginModelo->construir();
            $row = $res->rowCount();
            if($row > 0){
                foreach ($res as $key => $value) {}
           
                if($value['hoy'] < $value['fecha_limite_verificacion']){
                    include('vista/cliente/login/password.php');
                }else{
                    echo "Ya fue vencido este codigo de su fecha limite";
                }
            }else{
                echo "Ya fue vencido este codigo de su fecha limite";
            }
        }else{
            echo "No envio el codigo";
        }

        include('vista/cliente/contacto/index.php');
        include('vista/cliente/footer/index.php');
    }

    public function cambiarPassword(){
            session_start();
            if($_POST){
                $correo = htmlspecialchars(addslashes($_POST['correo']));
                $passwordModificacion = password_hash(htmlspecialchars(addslashes($_POST['password'])), PASSWORD_DEFAULT,['cost' => 15]);
                
                //Quitar campo activo, si llegase a estorbar
                $this->loginModelo->set("activo","");
                $this->loginModelo->set("passwordModificacion",$passwordModificacion);
                $this->loginModelo->set("correo",$correo);

                $this->loginModelo->cambiarPassword();
                echo 1;
            }
        }

    public function iniciarSesion(){
        session_start();
        if($_POST){
            $usuario = htmlspecialchars(addslashes($_POST['usuario']));
            $password = htmlspecialchars(addslashes($_POST['password']));

            if(!isset($_POST['actividad'])){
                $actividad = "normal";
            }else{
                $actividad = htmlspecialchars(addslashes($_POST['actividad']));
            }

            //Setear en blanco, que no interfiera con esta consulta a continuación
            $this->loginModelo->set("correo","");
            $this->loginModelo->set("idUsuario","");
            $this->loginModelo->set("codigoVerificacion","");
            $this->loginModelo->set("activo","");

            //Setear el nombre de usuario que queramos obtener los datos
            $usuarioSQL = " AND (u.usuario = '$usuario') OR (u.correo = '$usuario') ";
            $this->loginModelo->set("usuario",$usuarioSQL);

            //Obtener los datos especificos del usuario
            $res = $this->loginModelo->construir();

            $row = $res->rowCount();
            if($row > 0){

                foreach ($res as $key){
                    if($key['password_modificacion_activo'] == 1){
                        $hash = $key['password_modificacion'];
                    }else{
                        $hash = $key['password'];
                    }
                    $idUsuario =  $key['id_usuario'];
                    $usuario = $key['usuario'];
                    $correo = $key['correo'];
                    $imagen = $key['imagen'];
                }                

                if(password_verify($password, $hash)){
                    
                    $_SESSION['idUsuario'] = $idUsuario;
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['imagen'] = $imagen;

                    if($actividad === "favorito"){
                        $idProducto = htmlspecialchars(addslashes($_POST['idProducto']));
                        $this->productoFavoritoControlador->productoFavorito($idProducto);
                        echo 1; //Todo bien, inicia añadiendo en favorito
                    }elseif($actividad === "carrito"){
                        $idProducto = htmlspecialchars(addslashes($_POST['idProducto']));
                        $this->productoCarritoControlador->addProductoCarrito($idProducto);
                        echo 2; //Todo bien, inicia añadiendo al carrito
                    }else if($actividad === "normal"){
                        echo 3; //todo bien, inicia normal
                    }
                }else{
                    echo 4; //Usuario o contraseña mal
                }
            }else{
                echo 4; //Usuario o contraseña mal
            }

        }
    }

    public function usuarioNuevo(){
        if($_POST){

            //Obtener datos
            $usuario = htmlspecialchars(addslashes($_POST['usuario']));
            $password = htmlspecialchars(addslashes($_POST['password']));
            $passwordHash = password_hash($password, PASSWORD_DEFAULT,['cost' => 15]);
            $correo = htmlspecialchars(addslashes($_POST['correo']));

            //Iniciar instancia
            $this->validarCorreoControlador = new validarCorreoControlador();

            //Validar estructura
            $correoValidado = $this->validarCorreoControlador->validarCorreo($correo);
            if($correoValidado){
                //Validar correo en uso
                $correoSQL = " AND u.correo = '$correo' ";
                $this->loginModelo->set("correo",$correoSQL);
                $res = $this->loginModelo->construir();
                $row = $res->rowCount();
                if($row > 0){
                    echo 5; //Correo en uso
                }else{
                    //Validar usuario en uso
                    $usuarioSQL = " AND u.usuario = '$usuario' ";
                    //Setear usuario
                    $this->loginModelo->set("correo",""); //Le quitamos el valor del correo
                    $this->loginModelo->set("usuario",$usuarioSQL);
                    $res = $this->loginModelo->construir();
                    $row = $res->rowCount();
                    if($row > 0){
                          echo 4; //Usuario en uso
                    }else{
                        //Seteamos los datos
                        $this->loginModelo->set("correo",$correo); 
                        $this->loginModelo->set("usuario",$usuario);
                        $this->loginModelo->set("password",$passwordHash);

                        //Insertamos el nuevo usuario
                        $this->loginModelo->usuarioNuevo();
                        $this->enviarCorreoControlador = new enviarCorreoControlador();

                        $mensaje = file_get_contents('vista/cliente/correo/basico.php');
                        $mensaje = str_replace("{{year}}", date('Y'), $mensaje);
                        $mensaje = str_replace("{{asunto}}", "!Bienvenido!", $mensaje);
                        $mensaje = str_replace("{{mensaje}}", "¡Gracias por registrarte con nosotros! ¡te esperan muchas ofertas y nuevos productos!.", $mensaje);

                        $asunto = "MIRENNAY te da la Bienvenida.";
                        $this->enviarCorreoControlador->enviarCorreo($correo,$asunto,$mensaje);
                        echo 1;
                    }
                }
            }else{
                echo 3; //Correo invalido
            }

        }
    }

    public function activarCodigoVerificacion(){
        date_default_timezone_set("Mexico/General");
        if($_POST){
            $correo = htmlspecialchars(addslashes($_POST['correo']));

            //Iniciar instancia
            $this->validarCorreoControlador = new validarCorreoControlador();
            $this->enviarCorreoControlador = new enviarCorreoControlador();

            $correoValidado = $this->validarCorreoControlador->validarCorreo($correo);

            if($correoValidado){

                $correoSQL = " AND u.correo = '$correo' ";
                $activoSQL = " AND u.activo = 1";

                //Setear datos 
                $this->loginModelo->set("correo",$correoSQL);
                $this->loginModelo->set("activo",$activoSQL);

                $res = $this->loginModelo->construir();
                $row = $res->rowCount();
                if($row > 0){

                    //Datos del correo
                    $codigoVerificacion = $this->crearCodigoVerificacion();
                    $fechaLimiteVerificacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
                    $asunto = "Recuperación de password";
                    $link = URL."login/password?codigoVerificacion=$codigoVerificacion";
                    $texto = "Entra a este link, solo tienes 24 horas antes de que caduque $link";

                    //Setear correo,codigo,fechaLimite
                    $this->loginModelo->set("correo",$correo);
                    $this->loginModelo->set("codigoVerificacion",$codigoVerificacion);
                    $this->loginModelo->set("fechaLimiteVerificacion",$fechaLimiteVerificacion);

                    //Ejecutar la funcion que modifica que se activara el codigo
                    $this->loginModelo->activarCodigoVerificacion();

                    $mensaje = file_get_contents('vista/cliente/correo/basico.php');
                    $mensaje = str_replace("{{year}}", date('Y'), $mensaje);
                    $mensaje = str_replace("{{asunto}}", $asunto, $mensaje);
                    $mensaje = str_replace("{{mensaje}}", $texto, $mensaje);

                    $retorno = $this->enviarCorreoControlador->enviarCorreo($correo,$asunto,$mensaje);
                    if($retorno){
                        echo 1;
                    }else{
                        echo "Error: ".$retorno;
                    }
                }else{
                    echo 3; //No se encontro ningun dato con ese correo
                }                   
            }else{
                echo 2;
            }
        }else{
            echo "No se enviaron datos via post";
        }
    }

    public function crearCodigoVerificacion(){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789987654321";
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
        session_destroy();
    }

}
?>
