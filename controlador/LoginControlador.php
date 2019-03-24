<?php

require_once 'modelo/LoginModelo.php';
require_once 'controlador/ProductoFavoritoControlador.php';
require_once 'controlador/ProductoCarritoControlador.php';

class LoginControlador {

    private $loginModelo;
    private $productoFavoritoControlador;
    private $productoCarritoControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->loginModelo = new LoginModelo();
        $this->productoFavoritoControlador = new ProductoFavoritoControlador();
        $this->productoCarritoControlador = new ProductoCarritoControlador();
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

    public function iniciarSesion(){
        session_start();
        if($_POST){
           $usuario = htmlspecialchars(addslashes($_POST['usuario']));
           $password = htmlspecialchars(addslashes($_POST['password']));
           $actividad = htmlspecialchars(addslashes($_POST['actividad']));
           $res = $this->loginModelo->iniciarSesion($usuario,$password);
           if($res != false){
            foreach ($res as $key) {
                $_SESSION['idUsuario'] = $key['id_usuario'];
                $_SESSION['usuario'] = $key['usuario'];
                $_SESSION['correo'] = $key['correo'];
                $_SESSION['rol'] = $key['rol'];
            }
            if($actividad == "favorito"){
                $idProducto = htmlspecialchars(addslashes($_POST['idProducto']));
                $this->productoFavoritoControlador->productoFavorito($idProducto);
                echo 1;
            }elseif($actividad == "carrito"){
                $idProducto = htmlspecialchars(addslashes($_POST['idProducto']));
                $this->productoCarritoControlador->addProductoCarrito($idProducto);
                echo 2;
            }else if($actividad == "normal"){
                echo 3;
            }
           }else{
            echo 4;
           }
        }
    }

    public function usuarioNuevo(){
        session_start();
        if($_POST){
            $usuario = htmlspecialchars(addslashes($_POST['usuario']));
            $password = htmlspecialchars(addslashes($_POST['password']));
        }
    }

    public function validarCorreo($email){ 
        $mail_correcto = 0; 
        //compruebo unas cosas primeras 
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
            if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
                //miro si tiene caracter . 
                if (substr_count($email,".")>= 1){ 
                    //obtengo la terminacion del dominio 
                    $term_dom = substr(strrchr ($email, '.'),1); 
                    //compruebo que la terminación del dominio sea correcta 
                    if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
                    //compruebo que lo de antes del dominio sea correcto 
                    $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
                    $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
                    if ($caracter_ult != "@" && $caracter_ult != "."){ 
                        $mail_correcto = 1; 
                    } 
                    } 
                } 
            } 
        } 
        if ($mail_correcto) {
            return 1; 
        }
        else{
            return 0; 
        }  
    }

    public function cerrarSesion(){
        session_start();
        session_destroy();
    }

}
?>
