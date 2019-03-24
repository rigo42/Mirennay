<?php

require_once 'controlador/ProductoNuevoControlador.php';
require_once 'controlador/ProductoMasVendidoControlador.php';
require_once 'controlador/CategoriaControlador.php';

class InicioControlador {

    private $productoNuevoControlador;
    private $productoMasVendidoControlador;
    private $categoriaControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoNuevoControlador = new ProductoNuevoControlador();
        $this->productoMasVendidoControlador = new ProductoMasVendidoControlador();
        $this->categoriaControlador = new CategoriaControlador();
    } 

	public function index() {
        session_start();
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
