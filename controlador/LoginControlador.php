<?php

require_once 'modelo/loginModelo.php';
require_once 'controlador/productoFavoritoControlador.php';
require_once 'controlador/productoCarritoControlador.php';
require_once 'controlador/validarCorreoControlador.php';

class loginControlador {

    private $loginModelo;
    private $productoFavoritoControlador;
    private $productoCarritoControlador;
    private $validarCorreoControlador;

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
            $correo = htmlspecialchars(addslashes($_POST['correo']));
            $correoValidado = $this->validarCorreoControlador->validarCorreo($correo);
            if($correoValidado){

            }else{
                
            }

        }
    }


    public function cerrarSesion(){
        session_start();
        session_destroy();
    }

}
?>
