<?php

require_once 'modelo/CategoriaModelo.php';

class CategoriaControlador {

    private $categoriaModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->categoriaModelo = new CategoriaModelo();
    } 

	public function coleccion() {
       return $this->categoriaModelo->coleccion();
	}

}
?>
