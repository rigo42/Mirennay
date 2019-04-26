<?php

require_once 'modelo/adminCategoriaModelo.php';

class adminCategoriaControlador {

    private $adminCategoriaModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminCategoriaModelo = new adminCategoriaModelo();
    } 

    //Funcion especial para ver todas las categorias que estan ligadas a los productos por parte de las sub categorias para la pagina de incio
	public function coleccion() {
       return $this->adminCategoriaModelo->coleccion();
	}

}
?>
