<?php

require_once 'controlador/productoNuevoControlador.php';
require_once 'controlador/productoMasVendidoControlador.php';
require_once 'controlador/categoriaControlador.php';

class inicioControlador {

    private $productoNuevoControlador;
    private $productoMasVendidoControlador;
    private $categoriaControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoNuevoControlador = new productoNuevoControlador();
        $this->productoMasVendidoControlador = new productoMasVendidoControlador();
        $this->categoriaControlador = new categoriaControlador();
    } 

	public function index() {
        session_start();
        $_SESSION['idEmpleado'] = 1; //quitar esto despues
        $_SESSION['rolEmpleado'] = "admin"; //quitar esto despues
        
		include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
		include('vista/cliente/menu/index.php');

    	include('vista/cliente/productoColeccion/index.php');
    	include('vista/cliente/productoNuevo/index.php');
        include('vista/cliente/productoPublicidad/index.php');
        include('vista/cliente/productoMasVendido/index.php');
        include('vista/cliente/productoMasVendidoMin/index.php');

    	include('vista/cliente/contacto/index.php');
    	include('vista/cliente/footer/index.php');
	}

}
?>
