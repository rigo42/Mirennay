<?php

require_once 'modelo/PerfilModelo.php';

class PerfilControlador {

    private $perfilModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->perfilModelo = new PerfilModelo();
    } 

	public function index() {
        session_start();
		include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
		include('vista/cliente/menu/index.php');


    	include('vista/cliente/contacto/index.php');
    	include('vista/cliente/footer/index.php');
	}

    public function direccion(){
        $idUsuario = $_SESSION['idUsuario'];
        return $this->perfilModelo->direccion($idUsuario);
    }
    
    public function direccionNueva($POST){
        $idUsuario = $_SESSION['idUsuario'];
        return  $idUsuarioDetalle = $this->perfilModelo->direccionNueva($POST,$idUsuario);
    }

}
?>
